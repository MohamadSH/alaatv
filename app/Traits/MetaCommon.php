<?php namespace App\Traits;

use colossal_mind_mb_keyword_gen;

trait MetaCommon
{
    /**
     *
     * Multibyte Keyword Generator
     * Copyright (c) 2009-2012, Peter Kahl. All rights reserved. www.colossalmind.com
     * Use of this source code is governed by a GNU General Public License
     * that can be found in the LICENSE file.
     *
     * https://github.com/peterkahl/multibyte-keyword-generator
     * @param $text
     * @param string $article_kw
     * @param string $global_kw
     * @param int $min_word_length
     * @param int $min_word_occur
     * @param int $min_2words_length
     * @param int $min_2words_phrase_length
     * @param int $min_2words_phrase_occur
     * @param int $min_3words_length
     * @param int $min_3words_phrase_length
     * @param int $min_3words_phrase_occur
     * @param string $encoding
     * @param string $lang
     */


    function generateKeywordsMeta($text /* the text */,
                                    $article_kw ='' /*  if some keywords are written by hand (by the author) ,
 												$article_kw = 'Obama, Washington, economy, jobs, USA , jobless,  politics , politic ,,, houses '; */,
                                    $global_kw =''/*if we have a default keyword for the whole site*/,
                                    $min_word_length = 3 /*  min length of single words */,
                                    $min_word_occur = 1 /*  min occur of single words */,
                                    $min_2words_length = 3 /*  min length of words for 2 word phrases; value 0 will DISABLE !!! */,
                                    $min_2words_phrase_length = 10 /* min length of 2 word phrases */,
                                    $min_2words_phrase_occur = 2 /* min occur of 2 words phrase */,
                                    $min_3words_length = 4 ,
                                    $min_3words_phrase_length = 12 ,
                                    $min_3words_phrase_occur = 2,
                                    $encoding = 'utf-8' /* // OPTIONAL, but VERY IMPORTANT
													   // if not defined, will default to UTF-8 */,
                                    $lang = 'fa_IR' /* // OPTIONAL
												// define the language of the text
												// if not defined, will default to English (en_GB) */
    ){
        // OPTIONAL
        // specify only if you want any languages to be ignored by the class
        // What it does: If the class encounters this language(s), it will
        // return empty string ''
        // ignore languages
        //	$params['ignore'] = array('zh_CN', 'zh_TW', 'ja_JP'); // must be an array; lower case; case sensitive !!!
        //----------------------------------------------------------------------

        // REQUIRED
        // load the text, either from database or a file
        // text MAY contain HTML tags
        $params['content'] = $text;
        $params['encoding'] = $encoding; // case insensitive
        $params['lang'] = $lang; // case insensitive
        // OPTIONAL
        // specify only if you want any languages to be ignored by the class
        // What it does: If the class encounters this language(s), it will
        // return empty string ''
        // ignore languages
//	$params['ignore'] = array('zh_CN', 'zh_TW', 'ja_JP'); // must be an array case sensitive !!!
        $params['min_word_length'] = $min_word_length;
        $params['min_word_occur'] = $min_word_occur;
        $params['min_2words_length'] =$min_2words_length;
        $params['min_2words_phrase_length'] = $min_2words_phrase_length;
        $params['min_2words_phrase_occur'] = $min_2words_phrase_occur;
        $params['min_3words_length']  = $min_3words_length;
        $params['min_3words_phrase_length'] = $min_3words_phrase_length;
        $params['min_3words_phrase_occur']  = $min_3words_phrase_occur;

        //----------------------------------------------------------------------
        //REQUIRED
        $keyword = new colossal_mind_mb_keyword_gen($params);
        // REQUIRED
        $autoKeywords = $keyword->get_keywords();

        $keywords = $global_kw .','. $autoKeywords .','. $article_kw;
        // BONUS FUNCTION
        // clean up keywords; remove ONLY duplicate words; remove identical PLURAL words (English)
        $keywords = $keyword->removeDuplicateKw($keywords);

        return $keywords;
    }
}