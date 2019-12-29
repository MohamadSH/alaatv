<?php


namespace App\HelpDesk\Traits;


use Stevebauman\Purify\Facades\Purify;

trait ContentCommon
{
    /**
     * Cuts the content of a comment or a ticket content if it's too long.
     *
     * @param string $attr
     *
     * @return string
     */
    public function getShortContent($attr = 'content'): string
    {
        $maxLength = config('helpDesk.MAX_LENGTH_CONTENT_PREVIEW');
        $content   = $this->{$attr};
        $content   = $this->getPurifiedContent($content);
        if (strlen($content) > $maxLength) {
            return mb_substr($content, 0, $maxLength, 'utf-8') ?? '';
        }
        return $content ?? '';
    }

    /**
     * @param $content
     *
     * @return array|string
     */
    private function getPurifiedContent($content)
    {
        return Purify::clean($content, self::$purifyNullConfig);
    }
}
