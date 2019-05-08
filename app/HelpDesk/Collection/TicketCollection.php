<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-03
 * Time: 19:06
 */

namespace App\HelpDesk\Collection;

use App\Traits\JsonResponseFormat;
use Illuminate\Database\Eloquent\Collection;

class TicketCollection extends Collection
{
    use JsonResponseFormat;
}