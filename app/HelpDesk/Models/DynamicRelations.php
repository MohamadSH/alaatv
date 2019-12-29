<?php

/**
 * Created by Iman Ghafoori . It's an incomplete work
 */

namespace App\HelpDesk\Models;

use BadMethodCallException;
use Closure;
use Illuminate\Support\Str;

trait DynamicRelations
{
    protected static $macros = [];

    public static function macro($name, $macro)
    {
        static::$macros[$name] = $macro;
    }

    public static function oneToManyWithReverse(string $class, $relationName = null, $foreignKey = null, $localKey = null)
    {
        self::belongs_to($class, $relationName, $foreignKey, $localKey);
        self::has_many($class, $relationName, $foreignKey, $localKey);
    }

    /**
     * @param string $class
     * @param        $relationName
     * @param null   $foreignKey
     * @param null   $ownerKey
     */
    public static function belongs_to($relationName = null, string $class, $foreignKey = null, $ownerKey = null): void
    {
        if (is_null($foreignKey)) {
            $foreignKey = Str::snake($relationName) . '_id';
        }

        static::defineRelation($class, 'belongsTo', static::class, $relationName, $foreignKey, $ownerKey);
    }

    private static function defineRelation(string $class1, string $relationType, string $class2, $relationName = null, $foreignKey, $localKey): void
    {
        $class2::macro($relationName, function () use ($class1, $relationType, $foreignKey, $localKey) {
            return $this->{$relationType} ($class1, $foreignKey, $localKey);
        });
    }

    /**
     * @param string $class
     * @param        $relationName
     * @param null   $foreignKey
     * @param null   $localKey
     */
    public static function has_many($relationName = null, string $class, $foreignKey = null, $localKey = null): void
    {
        static::defineRelation($class, 'hasMany', static::class, $relationName, $foreignKey, $localKey);
    }

    public static function hasManyToMany($relatedClass, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                         $parentKey = null, $relatedKey = null): void
    {
        $relation     = $relatedClass[0];
        $relatedClass = $relatedClass[1];
        $params       = [$relatedClass, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relation];
        static::defineBelongsToMany(static::class, $params, $relation);
    }

    public static function defineBelongsToMany($class1, $params, $relation): void
    {
        $class1::macro($relation, function () use ($params) {
            return $this->belongsToMany(...$params);
        });
    }

    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (method_exists($this, $key) or self::hasMacro($key)) {
            return $this->getRelationshipFromMethod($key);
        }
    }

    public static function hasMacro($name)
    {
        return isset(static::$macros[$name]);
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            return parent::__call($method, $parameters);
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            return call_user_func_array($macro->bindTo($this, static::class), $parameters);
        }

        return call_user_func_array($macro, $parameters);
    }
}
