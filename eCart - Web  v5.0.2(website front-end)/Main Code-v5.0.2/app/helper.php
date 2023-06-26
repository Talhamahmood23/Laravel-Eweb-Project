<?php

function getJSON($string) {
    $j = json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE) ? $j : array('error' => true, 'message' => 'Invalid JSON Response');
}

function _asset($url) {
    return get('asset_url') . $url;
}

function theme($url) {
    return asset("themes/" . get('theme') . "/$url");
}

function get($key) {
   
     $theme  = config("ekart.$key");
     if($key == 'theme'){
        $theme = Cache::get('show_theme_on_website');
     }
     return $theme ?? 'eCart_02';
}


function api_param($key) {
    return get("api-params.$key");
}

function isLoggedIn() {
    return (session()->has('user') && isset(session()->get('user')['user_id']) && intval(session()->get('user')['user_id'])) ? true : false;
}

function getColor($index) {
    $arr = ['#ffd7d7', '#FFF68D', '#bcffb8', '#c9fff3', '#ddffeb', '#dee4ff', '#fff0c5'];
    if (isset($arr[$index])) {
        return $arr[$index];
    } else {
        return getColor(intval($index - count($arr)));
    }
}

function getMaxQty($v) {
    $stock_unit_name = isset($v->stock_unit_name) ? $v->stock_unit_name : '';
    if (intval($v->stock)) {

        $return = $v->stock;
    }
    if ($v->type == 'loose') {
        if ($stock_unit_name == 'kg' || $stock_unit_name == 'ltr') {
            $return = $v->stock * 1000;
        }
    }
    return $return ?? '';
}

function getMaxQtyAllowed($p) {

    $MaxAllowed_productwise = $p->total_allowed_quantity ?? 0;

    $MaxAllowed = intval(Cache::get('max_cart_items_count', 0));

    $return = $MaxAllowed_productwise > 0 ? $MaxAllowed_productwise : $MaxAllowed;

    return $return ?? '';
}

function calc_discount_percentage($oldprice, $newprice) {

    return intval(100 - intval(round(( ( doubleval($newprice) / doubleval($oldprice) ) * 100), 0, PHP_ROUND_HALF_UP)));
}

function get_varient_name($v) {

    $name = $v->measurement;
    if (isset($v->measurement_unit_name) && $v->measurement_unit_name != "") {
        $name .= " " . $v->measurement_unit_name;
    } elseif (isset($v->unit) && $v->unit != "") {
        $name .= " " . $v->unit;
    }

    return $name ?? '-';
}

function get_product_type($v) {


    if (isset($v->type) && $v->type != "") {

        $type = $v->type;
    }

    return $type ?? '-';
}

function get_unit_name($v) {


    if (isset($v->measurement_unit_name) && $v->measurement_unit_name != "") {

        $name = $v->measurement_unit_name;
    } elseif (isset($v->unit) && $v->unit != "") {

        $name = $v->unit;
    }

    return $name ?? '-';
}

function get_unit_number($v) {

    if (isset($v->measurement) && $v->measurement != "") {

        $number = $v->measurement;
    }

    return $number ?? '-';
}

function get_cart_stock($p) {
    $cart_stock = 0;
    foreach ($p->variants as $v) {
        if ($v->cart_count > 0 && ($v->measurement_unit_name == 'gm' || $v->measurement_unit_name == 'ml')) {
            $stock_smallvarient = $v->cart_count * $v->measurement;
            $cart_stock += $stock_smallvarient;
        }
        if ($v->cart_count > 0 && ($v->measurement_unit_name == 'kg' || $v->measurement_unit_name == 'ltr')) {
            $stock_bigvarient = $v->cart_count * ($v->measurement * 1000);
            $cart_stock += $stock_bigvarient;
        }
    }
    return $cart_stock;
}

function get_cart_stock_cart_page($p, $product_id, $sessionqty) {
    $cart_stock = 0;
    $maxqty = 0;

    foreach ($p as $v) {
        if (isset($v->qty)) {
            $qty = $v->qty;
        } else {
            $qty = $sessionqty;
        }
        if ($qty > 0 && isset($v->item[0]) && ($v->item[0]->unit == 'gm' || $v->item[0]->unit == 'ml') && $v->product_id == $product_id) {
            $stock_smallvarient = $qty * $v->item[0]->measurement;
            $cart_stock += $stock_smallvarient;
            $maxqty = $v->item[0]->stock;
        }
        if ($qty > 0 && isset($v->item[0]) && ($v->item[0]->unit == 'kg' || $v->item[0]->unit == 'ltr') && $v->product_id == $product_id) {
            $stock_bigvarient = $qty * ($v->item[0]->measurement * 1000);
            $cart_stock += $stock_bigvarient;
            $maxqty = $v->item[0]->stock * 1000;
        }
    }
    return $maxqty - $cart_stock;
}

function get_cart_count($v, $sessionqty) {
    if (isset($sessionqty)) {
        $cart_count = $sessionqty;
    } else {
        if (isset($v->cart_count)) {
            $cart_count = ($v->cart_count > 0 ? $v->cart_count : 1);
        } else {
            $cart_count = ($v->qty > 0 ? $v->qty : 1);
        }
    }
    return $cart_count;
}

function get_main_image($p) {
    $main_images = '';
    
    if(isset($p->image)){
        
    $main_image =  $p->image;
    
    }
    
    return $main_image;
}

function get_gallery_images($v) {
    $gallery_images = '';
    
    if(isset($v->images)){
        
    $gallery_images = implode(",", $v->images);
    
    }
    
    return $gallery_images;
}

function get_price($p, $isFree = true) {

    if (floatval($p) > 0) {

        return (Cache::has('currency') ? Cache::get('currency') : '') . " " . $p;
    } elseif ($isFree) {

        return "Free";
    } else {

        return (Cache::has('currency') ? Cache::get('currency') : '') . " 0";
    }
}

function get_savings_varients($v, $inPerecentage = true) {
    date_default_timezone_set("Asia/Kolkata");
    $date = new \DateTime();
    $now = date_format($date, 'Y-m-d H:i:s');
    $is_flash_sales = isset($v->is_flash_sales) ? $v->is_flash_sales : false;
    $end_date = isset($v->flash_sales[0]->end_date) ? $v->flash_sales[0]->end_date : false;
    $discounted_price = isset($v->flash_sales[0]->discounted_price) ? $v->flash_sales[0]->discounted_price : '';
    $price = isset($v->flash_sales[0]->price) ? $v->flash_sales[0]->price : '';
    if (isset($v->tax_percentage) && $v->tax_percentage > 0) {
        $discounted_price_tax = intval($discounted_price) + (intval($discounted_price) * intval($v->tax_percentage) / 100);
        $price_tax = intval($price) + (intval($price) * intval($v->tax_percentage) / 100);
    }



    if ($is_flash_sales == "true" && $end_date > $now) {
        if (isset($discounted_price) && intval($discounted_price) > 0) {

            if (intval($price)) {

                if (isset($v->tax_percentage) && $v->tax_percentage > 0) {

                    $result = $discounted_price_tax + ($discounted_price_tax * $v->tax_percentage / 100) * 100 / $price;
                } else {
                    $result = $discounted_price * 100 / $price;
                }

                $percentage = "";

                if (intval($result)) {

                    $percentage = intval(100 - intval($result)) . " % Off";
                }

                if ($inPerecentage) {

                    return $percentage;
                } else {
                    if (isset($v->tax_percentage) && $v->tax_percentage > 0) {

                        return intval(intval($price_tax) - intval($discounted_price_tax)) . " ($percentage)";
                    } else {
                        return intval(intval($price) - intval($discounted_price)) . " ($percentage)";
                    }
                }
            }
        }
    } else {
        if (isset($v->discounted_price) && intval($v->discounted_price) > 0) {

            if (intval($v->price)) {

                $result = $v->discounted_price * 100 / $v->price;

                $percentage = "";

                if (intval($result)) {

                    $percentage = intval(100 - intval($result)) . " % Off";
                }

                if ($inPerecentage) {

                    return $percentage;
                } else {

                    return intval(intval($v->price) - intval($v->discounted_price)) . " ($percentage)";
                }
            }
        }
    }

    return "";
}

function get_mrp_varients($v) {

    if (floatval($v->discounted_price) > 0) {

        return round($v->price);
    } else {

        return "0";
    }
}

function get_pricetax_varients($t) {
    return $t;
}

function get_price_varients($v, $decimal = 2) {

    $price = 0;

    date_default_timezone_set("Asia/Kolkata");
    $date = new \DateTime();
    $now = date_format($date, 'Y-m-d H:i:s');
    $is_flash_sales = isset($v->is_flash_sales) ? $v->is_flash_sales : false;
    $end_date = isset($v->flash_sales[0]->end_date) ? $v->flash_sales[0]->end_date : false;
    $discounted_price = isset($v->flash_sales[0]->discounted_price) ? $v->flash_sales[0]->discounted_price : '';
    if ($is_flash_sales == "true" && $end_date > $now) {
        if ($discounted_price > 0) {
            return $price = $discounted_price;
        }
    } else {

        if (floatval($v->discounted_price) > 0) {

            return $price = $v->discounted_price;
        } else {
            return $price = $v->price;
        }
    }
}

function get_sale_end_time($v, $decimal = 2) {
    $is_flash_sales = isset($v->is_flash_sales) ? $v->is_flash_sales : false;
    $end_date = isset($v->flash_sales[0]->end_date) ? $v->flash_sales[0]->end_date : false;
    return $end_date;
}

function get_price_mrp($v, $decimal = 2) {

    $price = 0;

    $price = $v->price;

    if (intval($decimal)) {

        return number_format($price, intval($decimal));
    } else {

        return round($price);
    }
}

function print_discount_percentage($v) {

    $return = "";

    if ($v->discounted_price > 0) {

        $discount = calc_discount_percentage($v->price, $v->discounted_price);

        if ($discount > 0) {

            $return = $discount . " % OFF";
        } elseif ($discount == 100) {

            $return = "Free";
        }
    }

    return $return;
}

function print_mrp($v) {

    if (isset($v->variants[0])) {

        $s = $v->variants[0];
    }

    if ($s->discounted_price ?? 0 > 0 && $s->discounted_price != $s->price) {

        if (isset($v->tax_percentage) && $v->tax_percentage > 0) {
            $tax_price = $s->price + ($s->price * $v->tax_percentage / 100);
            return "<s><!--M.R.P.:--> " . get_price(round($tax_price)) . "</s>";
        } else {
            return "<s><!--M.R.P.:--> " . get_price(round($s->price)) . "</s>";
        }
    }

    return "";
}

function print_price($v) {
    date_default_timezone_set("Asia/Kolkata");
    $date = new \DateTime();
    $now = date_format($date, 'Y-m-d H:i:s');

    if (isset($v->variants[0])) {

        $s = $v->variants[0];
    }

    if (isset($s->discounted_price)) {

        if ($s->discounted_price > 0) {
            $is_flash_sales = isset($s->is_flash_sales) ? $s->is_flash_sales : false;
            $end_date = isset($s->flash_sales[0]->end_date) ? $s->flash_sales[0]->end_date : false;
            $discounted_flash_price = isset($s->flash_sales[0]->discounted_price) ? $s->flash_sales[0]->discounted_price : '';

            if ($s->discounted_price != $s->price) {
                if ($is_flash_sales == "true" && $end_date > $now) {
                    if (isset($v->tax_percentage) && $v->tax_percentage > 0) {
                        $tax_price = $discounted_flash_price + ($discounted_flash_price * $v->tax_percentage / 100);
                        return "<!--Tax Including Offer Price--> " . get_price(round($tax_price));
                    } else {
                        return "<!--Offer Price--> " . get_price(round($discounted_flash_price));
                    }
                } else {
                    if (isset($v->tax_percentage) && $v->tax_percentage > 0) {
                        $tax_price = $s->discounted_price + ($s->discounted_price * $v->tax_percentage / 100);
                        return "<!--Tax Including Offer Price--> " . get_price(round($tax_price));
                    } else {
                        return "<!--Offer Price--> " . get_price(round($s->discounted_price));
                    }
                }
            }
        } else {
            if (isset($v->tax_percentage) && $v->tax_percentage > 0) {
                $tax_price = $s->price + ($s->price * $v->tax_percentage / 100);

                return "<!--Tax Including Price--> " . get_price(round($tax_price));
            } else {
                return "<!--Price--> " . get_price(round($s->price));
            }
        }
    } else {

        return "";
    }
    //return  get_price($s->discounted_price);
}

function print_saving($v) {

    if (isset($v->variants)) {

        $v = $v->variants[0];
    }


    if ($v->discounted_price > 0) {

        return "Offer Price " . get_price($v->discounted_price);
    } else {

        return get_price($v->price);
    }
}

function getSlug($title, $slugArray = [], $increment = 0) {

    $slug = slugify($title);

    if (isset($slugArray[$slug])) {

        if ($increment > 0) {

            if (isset($slugArray[$slug . "-" . $increment])) {

                $slug = getSlug($slug, $slugArray, $increment + 1);
            }
        } else {

            $slug = getSlug($slug, $slugArray, 1);
        }
    }

    return $slug;
}

function slugify($text) {

    // replace non letter || digits by -
    $text = preg_replace('/\s+/u', '-', trim($text));

    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function get_order_status($status) {

    $orderStatus = array('received' => false, 'processed' => false, 'shipped' => false, 'delivered' => false);

    if (count($status)) {

        foreach ($status as $s) {

            foreach ($orderStatus as $k => $v) {

                if ($k == $s[0]) {

                    $orderStatus[$k] = $s[1];
                }
            }
        }
    }

    return $orderStatus;
}

if (!function_exists('hmac_sha256')) {

    function hmac_sha256($data, $key) {

        return hash_hmac("sha256", $data, $key);
    }

}

function res($success = false, $msg = "", $data = [], $response = 200) {

    if (is_array($msg)) {

        $msg = $msg[0];
    } elseif (is_string($msg)) {

        if (trim($msg) == "") {

            if ($success) {

                $msg = "Success";
            } else {

                $msg = "Something Went Wrong";
            }
        }
    }

    return response()->json([
                'success' => $success,
                'message' => $msg,
                'data' => $data
                    ], $response);
}

function msg($k) {
    return trans("msg.$k");
}

function getTxnId() {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, 16);
}

function getInStockVarients($p) {
    $variants = [];

    foreach ($p->variants as $k => $v) {

        if ($v->serve_for == "Sold Out") {
            
        } elseif (intval($v->stock) < 1) {
            
        } else {
            $variants[] = $v;
            //$variants[$k]->tax_percentage = $p->tax_percentage;
        }
    }

    return $variants;
}
