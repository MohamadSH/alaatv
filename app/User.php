<?php

namespace App;

use App\Classes\Taggable;
use App\Classes\Verification\MustVerifyMobileNumber;
use App\Collection\ContentCollection;
use App\Collection\OrderCollections;
use App\Collection\OrderproductCollection;
use App\Collection\ProductCollection;
use App\Collection\SetCollection;
use App\Collection\UserCollection;
use App\HelpDesk\AgentInterface;
use App\HelpDesk\Collection\TicketCollection;
use App\HelpDesk\Models\Category;
use App\HelpDesk\Models\Ticket;
use App\HelpDesk\Traits\AgentTrait;
use App\Traits\APIRequestCommon;
use App\Traits\CharacterCommon;
use App\Traits\DateTrait;
use App\Traits\HasWallet;
use App\Traits\Helper;
use App\Traits\MustVerifyMobileNumberTrait;
use App\Traits\OrderCommon;
use App\Traits\User\{BonTrait,
    DashboardTrait,
    LotteryTrait,
    MutatorTrait,
    PaymentTrait,
    ProfileTrait,
    TaggableUserTrait,
    TeacherTrait,
    TrackTrait,
    VouchersTrait};
use Carbon\Carbon;
use Eloquent;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\QueryBuilder;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\User
 *
 * @property int
 *               $id
 * @property string|null
 *               $firstName                نام کوچک
 * @property string|null
 *               $lastName                 نام خانوادگی
 * @property string|null
 *               $mobile                   شماره موبایل
 * @property string|null
 *               $phone                    شماره تلفن ثابت
 * @property string|null
 *               $whatsapp                 اکانت واتس اپ
 * @property string|null
 *               $skype                    اکانت اسکایپ
 * @property int
 *               $mobileNumberVerification شماره تماس تایید شده است یا خیر
 * @property string|null
 *               $nationalCode             کد ملی
 * @property string
 *               $password                 رمز عبور
 * @property int
 *               $userstatus_id            آیدی مشخص کننده وضعیت کاربر
 * @property int
 *               $lockProfile              قفل بودن با نبودن پروفایل
 * @property string|null
 *               $photo                    عکس شخصی
 * @property string|null
 *               $province                 استان محل سکونت
 * @property string|null
 *               $city                     شهر محل سکونت
 * @property string|null
 *               $address                  آدرس محل سکونت
 * @property string|null
 *               $postalCode               کد پستی محل سکونت
 * @property string|null
 *               $school                   مدرسه ی محل تحصیل
 * @property int|null
 *               $major_id                 آیدی رشته تحصیل کاربر
 * @property int|null
 *               $grade_id                 آی دی مشخص کننده مقطع
 * @property int|null
 *               $gender_id                آیدی جنیست کاربر
 * @property string|null
 *               $birthdate                تاریخ تولد
 * @property string|null
 *               $remember_token
 * @property string|null
 *               $passwordRegenerated_at   تاریخ آخرین تولید خودکار(بازیابی) رمز عبور
 * @property Carbon|null
 *               $created_at
 * @property Carbon|null
 *               $updated_at
 * @property Carbon|null
 *               $deleted_at
 * @property string|null
 *               $email                    ایمیل کاربر
 * @property string|null
 *               $bio                      معرفی کاربر
 * @property string|null
 *               $introducedBy             نحوه ی آشنایی با شرکت
 * @property int|null
 *               $bloodtype_id             گروه خونی
 * @property string|null
 *               $allergy                  آلرژی به ماده خاص
 * @property string|null
 *               $medicalCondition         بیماری یا شرایط پزشکی خاص
 * @property string|null
 *               $diet                     رژیم غذایی خاص
 * @property string|null
 *               $techCode                 کد تکنسین
 * @property string                                     $full_name
 * @property string                                     whatsapp
 * @property string                                     skype
 * @property string                                     province
 * @property string                                     city
 * @property string                                     address
 * @property string                                     postalCode
 * @property string                                     school
 * @property string                                     bio
 * @property string                                     introducedBy
 * @property int                                        bloodtype_id
 * @property string                                     allergy
 * @property string                                     medicalCondition
 * @property string                                     diet
 * @property Userstatus                                 userstatus
 * @property-read Collection|Bankaccount[]
 *                    $bankaccounts
 * @property-read Bloodtype|null
 *                    $bloodtype
 * @property-read Collection|Contact[]
 *                    $contacts
 * @property-read Collection|Content[]
 *                    $contents
 * @property-read Collection|Employeeschedule[]
 *                    $employeeschedules
 * @property-read Collection|Employeetimesheet[]
 *                    $employeetimesheets
 * @property-read Collection|Eventresult[]
 *                    $eventresults
 * @property-read Gender|null
 *                    $gender
 * @property-read mixed
 *                    $full_name
 * @property-read Grade|null
 *                    $grade
 * @property-read Collection|Lottery[]
 *                    $lotteries
 * @property-read Major|null
 *                    $major
 * @property-read Collection|Mbtianswer[]
 *                    $mbtianswers
 * @property-read DatabaseNotificationCollection|DatabaseNotification[]
 *                $notifications
 * @property-read Collection|Order[]
 *                    $openOrders
 * @property-read Collection|Transaction[]
 *                    $orderTransactions
 * @property-read Collection|Ordermanagercomment[]
 *                    $ordermanagercomments
 * @property-read Collection|Orderproduct[]
 *                    $orderproducts
 * @property-read Collection|Order[]
 *                    $orders
 * @property-read Collection|Permission[]
 *                    $permissions
 * @property-read Collection|Productvoucher[]
 *                    $productvouchers
 * @property-read Collection|Role[]
 *                    $roles
 * @property-read Collection|Websitepage[]
 *                    $seensitepages
 * @property-read Collection|Transaction[]
 *                    $transactions
 * @property-read Collection|Userbon[]
 *                    $userbons
 * @property-read Userstatus
 *                    $userstatus
 * @property-read Collection|Usersurveyanswer[]
 *                    $usersurveyanswers
 * @property-read Collection|Userupload[]
 *                    $useruploads
 * @property-read Collection|Transaction[]
 *                    $walletTransactions
 * @property-read Collection|Wallet[]
 *                    $wallets
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAllergy($value)
 * @method static Builder|User whereBio($value)
 * @method static Builder|User whereBirthdate($value)
 * @method static Builder|User whereBloodtypeId($value)
 * @method static Builder|User whereCity($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDiet($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereGenderId($value)
 * @method static Builder|User whereGradeId($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIntroducedBy($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereLockProfile($value)
 * @method static Builder|User whereMajorId($value)
 * @method static Builder|User whereMedicalCondition($value)
 * @method static Builder|User whereMobile($value)
 * @method static Builder|User whereMobileNumberVerification($value)
 * @method static Builder|User whereNationalCode($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePasswordRegeneratedAt($value)
 * @method static Builder|User wherePermissionIs($permission = '')
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePhoto($value)
 * @method static Builder|User wherePostalCode($value)
 * @method static Builder|User whereProvince($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleIs($role = '')
 * @method static Builder|User whereSchool($value)
 * @method static Builder|User whereSkype($value)
 * @method static Builder|User whereTechCode($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUserstatusId($value)
 * @method static Builder|User whereWhatsapp($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|User role($roles)
 * @property string|null
 *               $nameSlug                 اسلاگ شده نام
 * @property-read mixed
 *                    $full_name_reverse
 * @method static Builder|User whereNameSlug($value)
 * @property string|null
 *               $mobile_verified_code     کد تایید شماره موبایل
 * @property string|null
 *               $mobile_verified_at       تاریخ تایید شماره موبایل
 * @property-read ContentCollection|Content[]
 *                    $favoredContents
 * @property-read ProductCollection|Product[]
 *                    $favoredProducts
 * @property-read Collection|Contentset[]
 *                    $favoredSets
 * @method static Builder|User whereMobileVerifiedAt($value)
 * @method static Builder|User whereMobileVerifiedCode($value)
 * @property string|null                                $email_verified_at
 * @property-read mixed                                 $reverse_full_name
 * @property-write mixed                                $first_name
 * @property-write mixed                                $last_name
 * @property-write mixed                                $medical_condition
 * @property-write mixed                                $postal_code
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @property-read OrderproductCollection|Orderproduct[] $closedorderproducts
 * @property mixed                                      mobile
 * @property string                                     lastName
 * @property string                                     firstName
 * @property int                                        id
 * @method static Builder|User active()
 * @method static select()
 * @property-read mixed                                 $number_of_products_in_basket
 * @property-read mixed                                 $short_name
 * @property-read mixed                                 $completion_info
 * @property-read mixed                                 $gender_info
 * @property-read mixed                                 $grade_info
 * @property-read mixed                                 $major_info
 * @property-read mixed                                 $wallet_info
 * @property-read Collection|Client[]                   $clients
 * @property-read mixed                                 $info
 * @property-read Collection|Token[]                    $tokens
 * @property mixed                                      openOrders
 * @property mixed                                      nameSlug
 * @property mixed                                      nationalCode
 * @property mixed                                      userstatus_id
 * @property mixed                                      techCode
 * @property string                                     password
 * @property int                                        lockProfile
 * @property string                                     photo
 * @property mixed                                      roles
 * @property null                                       mobile_verified_at
 * @property mixed                                      email
 * @property-read OrderCollections|Order[]              $closedOrders
 * @property-read Collection|Firebasetoken[]            $firebasetokens
 * @property-read mixed                                 $user_status
 * @property mixed                                      updated_at
 * @property mixed                                      created_at
 * @method static Builder|User orWherePermissionIs($permission = '')
 * @method static Builder|User orWhereRoleIs($role = '', $team = null)
 * @property string|null                                $lastServiceCall آخرین تماس کارمندان روابط عمومی با کاربر
 * @method static Builder|User whereLastServiceCall($value)
 * @property-read TicketCollection|Ticket[]             $agentTickets
 * @property-read int|null                              $agent_tickets_count
 * @property-read int|null                              $bankaccounts_count
 * @property-read int|null                              $clients_count
 * @property-read int|null                              $closedorderproducts_count
 * @property-read int|null                              $contacts_count
 * @property-read int|null                              $contents_count
 * @property-read Collection|Contract[]                 $contracts
 * @property-read int|null                              $contracts_count
 * @property-read int|null                              $eventresults_count
 * @property-read int|null                              $favored_contents_count
 * @property-read int|null                              $favored_products_count
 * @property-read int|null                              $favored_sets_count
 * @property-read int|null                              $firebasetokens_count
 * @property-read mixed                                 $edit_link
 * @property-read mixed                                 $jalali_created_at
 * @property-read mixed                                 $jalali_updated_at
 * @property-read mixed                                 $remove_link
 * @property-read mixed                                 $total_bon_number
 * @property-read Collection|Category[]                 $helpCategories
 * @property-read int|null                              $help_categories_count
 * @property-read int|null                              $lotteries_count
 * @property-read int|null                              $mbtianswers_count
 * @property-read int|null                              $notifications_count
 * @property-read int|null                  $open_orders_count
 * @property-read int|null                  $order_transactions_count
 * @property-read int|null                  $ordermanagercomments_count
 * @property-read int|null                  $orderproducts_count
 * @property-read int|null                  $orders_count
 * @property-read int|null                  $permissions_count
 * @property-read int|null                  $productvouchers_count
 * @property-read int|null                  $roles_count
 * @property-read int|null                  $seensitepages_count
 * @property-read TicketCollection|Ticket[] $tickets
 * @property-read int|null                  $tickets_count
 * @property-read int|null                  $tokens_count
 * @property-read int|null                  $transactions_count
 * @property-read int|null                  $userbons_count
 * @property-read int|null                  $usersurveyanswers_count
 * @property-read int|null                  $useruploads_count
 * @property-read int|null                  $wallet_transactions_count
 * @property-read int|null                  $wallets_count
 * @property ProductCollection              favoredProducts
 * @property SetCollection                  favoredSets
 * @property ContentCollection              favoredContents
 * @method static Builder|User helpAdmins()
 * @method static Builder|User helpAgents()
 * @method static Builder|User permissionName($permissionName)
 * @method static Builder|User roleName($roleName)
 */
class User extends Authenticatable implements Taggable, MustVerifyMobileNumber, MustVerifyEmail, AgentInterface
{
    use HasApiTokens;
    use MustVerifyMobileNumberTrait;
    use Helper;
    use DateTrait;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use LaratrustUserTrait;
    use HasWallet;
    use Notifiable;
    use APIRequestCommon;
    use CharacterCommon;
    use OrderCommon;

    use DashboardTrait, MutatorTrait, TeacherTrait, LotteryTrait, PaymentTrait, BonTrait, VouchersTrait, TaggableUserTrait, ProfileTrait, TrackTrait;
    use AgentTrait;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'info',
        'full_name',
        'userstatus',
        'roles',
        'totalBonNumber',
        'jalaliCreatedAt',
        'jalaliUpdatedAt',
        'editLink',
        'removeLink',
        'cacheClearUrl',
    ];

    protected $cascadeDeletes = [
        'orders',
        'userbons',
        'useruploads',
        'bankaccounts',
        'contacts',
        'mbtianswers',
        //        'favorables',
    ];

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'birthdate',
        'email_verified_at',
    ];

    protected $lockProfileColumns = [
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'gender_id',
        'major_id',
        'email',
    ];

    //columns being used for locking user's profile
    protected $completeInfoColumns = [
        'photo',
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'gender_id',
        'major_id',
        'grade_id',
        'phone',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];

    protected $medicalInfoColumns = [
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile',
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'photo',
        'major_id',
        'grade_id',
        'birthdate',
        'gender_id',
        'email',
        'bio',
        'introducedBy',
        'phone',
        'whatsapp',
        'skype',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
        'firstName',
        'lastName',
        'nationalCode',
        'nameSlug',
        'mobile',
        'userstatus_id',
        'techCode',
        'mobile_verified_code',
        'password' //For registering user
    ];

    protected $fillableByPublic = [
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'major_id',
        'grade_id',
        'birthdate',
        'gender_id',
        'email',
        'bio',
        'introducedBy',
        'phone',
        'whatsapp',
        'skype',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'major',
        'major_id',
        'grade',
        'grade_id',
        'gender',
        'gender_id',
        'mobile_verified_code',
        'mobileNumberVerification',
        'phone',
        'userstatus_id',
        'birthdate',
        'passwordRegenerated_at',
        'deleted_at',
        'techCode',
        'password',
        'remember_token',
        'wallets',
        'userbons',
    ];

    public static function getNullInstant($visibleArray = [])
    {
        $user = new User();
        foreach ($visibleArray as $key) {
            $user->$key = null;
        }
        return $user;
    }

    public static function roleFilter($users, $rolesId)
    {
        $users = $users->whereHas('roles', function ($q) use ($rolesId) {
            $q->whereIn("id", $rolesId);
        });
        return $users;
    }

    public static function majorFilter($users, $majorsId)
    {

        if (in_array(0, $majorsId))
            $users = $users->whereDoesntHave("major");
        else
            $users = $users->whereIn("major_id", $majorsId);

        return $users;
    }

    public function getAppToken()
    {
        $tokenResult = $this->createToken('Alaa App.');

        return [
            'access_token'     => $tokenResult->accessToken,
            'token_type'       => 'Bearer',
            'token_expires_at' => Carbon::parse($tokenResult->token->expires_at)
                ->toDateTimeString(),
        ];
    }

    public function routeNotificationForPhoneNumber()
    {
        return ltrim($this->mobile, '0');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return UserCollection
     */
    public function newCollection(array $models = [])
    {
        return new UserCollection($models);
    }

    public function hasFavoredProduct(Product $product): bool
    {
        return $this->favoredProducts->where('id', $product->id)->isNotEmpty();
    }

    public function hasFavoredSet(Contentset $contentSet): bool
    {
        return $this->favoredSets->where('id', $contentSet->id)->isNotEmpty();
    }

    public function hasFavoredContent(Content $content): bool
    {
        return $this->favoredContents->where('id', $content->id)->isNotEmpty();
    }

    /*
    |--------------------------------------------------------------------------
    | scope methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param Builder $query
     * @param array   $roles
     *
     * @return mixed
     */
    public function scopeRole($query, array $roles)
    {
        return $query->whereHas('roles', function ($q) use ($roles) {
            /** @var QueryBuilder $q */
            $q->whereIn('id', $roles);
        });
    }

    /**
     * @param Builder $query
     *
     * @param string  $roleName
     *
     * @return mixed
     */
    public function scopeRoleName($query, string $roleName)
    {
        $query->whereHas('roles', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    /**
     * @param Builder $query
     *
     *
     * @param string  $permissionName
     *
     * @return mixed
     */
    public function scopePermissionName($query, string $permissionName)
    {
        $query->whereHas('permissions', function ($q) use ($permissionName) {
            $q->where('name', $permissionName);
        });
    }


    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('userstatus_id', config('constants.USER_STATUS_ACTIVE'));
    }

    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */

    public function useruploads()
    {
        return $this->hasMany(Userupload::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function mbtianswers()
    {
        return $this->hasMany(Mbtianswer::class);
    }

    public function usersurveyanswers()
    {
        return $this->hasMany(Usersurveyanswer::class);
    }

    public function eventresults()
    {
        return $this->hasMany(Eventresult::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::Class);
    }

    public function firebasetokens()
    {
        return $this->hasMany(Firebasetoken::class);
    }

    public function lotteries()
    {
        return $this->belongsToMany(Lottery::Class)
            ->withPivot("rank", "prizes");
    }

    /**
     * @param $products
     *
     * @return mixed
     */
    public function getOrdersThatHaveSpecificProduct(ProductCollection $products)
    {
        $validOrders = $this->orders()
            ->whereHas('orderproducts', function ($q) use ($products) {
                $q->whereIn('product_id', $products->pluck('id'));
            })
            ->whereIn('orderstatus_id', [
                config('constants.ORDER_STATUS_CLOSED'),
                config('constants.ORDER_STATUS_POSTED'),
                config('constants.ORDER_STATUS_READY_TO_POST'),
            ])
            ->whereIn('paymentstatus_id', [
                config('constants.PAYMENT_STATUS_PAID'),
            ])
            ->get();
        return $validOrders;
    }

    public function cacheKey()
    {
        $key  = $this->getKey();
        $time = (optional($this->updated_at)->timestamp ?: optional($this->created_at)->timestamp) ?: 0;

        return sprintf('%s:%s-%s', $this->getTable(), $key, $time);
    }

    /**
     * Get userstatus that belongs to
     *
     * @return BelongsTo
     */
    public function userstatus()
    {
        return $this->belongsTo(Userstatus::class);
    }

    /**
     * Get related help categories
     *
     * @return BelongsToMany
     */
    public function helpCategories()
    {
        return $this->belongsToMany(Category::class, 'help_categories_users', 'user_id', 'category_id');
    }

    /**
     * Checks whether user has default avatar or not
     *
     * @param $photo
     *
     * @return bool
     */
    public function userHasDefaultAvatar(): bool
    {
        return strcmp($this->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0;
    }
}
