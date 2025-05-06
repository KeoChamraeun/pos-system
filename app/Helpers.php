<?php

use App\Models\Agency;
use App\Models\AgencyHistory;
use App\Models\AgencySetting;
use App\Models\AwardTarget;
use App\Models\Notification;
use App\Models\Role;
use App\Models\TransactionLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

//$khNUMTxt = array('', 'មួយ', 'ពីរ', 'បី', 'បួន', 'ប្រាំ');
//$twoLetter = array('', 'ដប់', 'ម្ភៃ', 'សាមសិប', 'សែសិប', 'ហាសិប', 'ហុកសិប', 'ចិតសិប', 'ប៉ែតសិប', 'កៅសិប');
//$khNUMLev = array('', '', '', 'រយ', 'ពាន់', 'មឿន', 'សែន', 'លាន');
//$khnum = array('០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩');

define("no_item_found", "No Record Found.!");

if (!function_exists('get_bank_account')) {
    function get_bank_account($agency, $bank_name)
    {
        $banks = json_decode($agency['bank_info'], true);
        $filter = array_filter($banks, function ($bank) use ($bank_name) {
            return strtoupper($bank['name']) === strtoupper($bank_name);
        });
        $bank_match = reset($filter);
        return $bank_match['account_number'] ?? '';
    }
}

// if (!function_exists('agency_translation')) {
//     function agency_translation($item)
//     {
//         if ($item) {
//             if (App::getLocale('locale') == 'en') {
//                 return $item->full_name;
//             } else {
//                 return $item->full_name_translate;
//             }
//         }
//     }
// }
// if (!function_exists('get_translation')) {
//     function get_translation($item)
//     {
//         if ($item) {
//             if (App::getLocale('locale') == 'en') {
//                 return $item->name;
//             } else {
//                 $lang = json_decode($item->languages, true);
//                 return $lang['name'];
//             }
//         }
//     }
// }

// if (!function_exists('get_name_translation')) {
//     function get_name_translation($item)
//     {
//         if ($item) {
//             if (App::getLocale('locale') == 'en') {
//                 return $item->name;
//             } else {
//                 return $item->name_translate;
//             }
//         }
//     }
// }


if (!function_exists('staff_profile')) {
    function staff_profile($file_name)
    {
        if ($file_name == null) {
            return asset('/assets/icon/profile-gray.png');
        } else {
            return asset($file_name);
        }
    }
}

if (!function_exists('check_user_exist')) {
    function check_user_exist($column, $value)
    {
        return User::where($column, $value)->first();
    }
}

if (!function_exists('get_money')) {
    function get_money($money)
    {
        $money_in = $money != '' ? $money : 0;
        return "$ " . number_format($money_in, 2);
    }
}


