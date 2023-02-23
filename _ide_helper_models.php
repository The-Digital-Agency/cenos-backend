<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\BankAccount
 *
 * @property int $id
 * @property string $account_name
 * @property string $account_number
 * @property string $bank_name
 * @property string $status
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUpdatedAt($value)
 */
	class BankAccount extends \Eloquent {}
}

namespace App{
/**
 * App\BankPayment
 *
 * @property int $id
 * @property string $payer_name
 * @property string $ammount_paid
 * @property string $status
 * @property \Illuminate\Support\Carbon $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment whereAmmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankPayment whereUpdatedAt($value)
 */
	class BankPayment extends \Eloquent {}
}

namespace App{
/**
 * App\Cart
 *
 * @property int $id
 * @property int $user_id
 * @property string $cart_object
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCartObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App{
/**
 * App\CashRequest
 *
 * @property int $id
 * @property string $itemRequest
 * @property int $amount
 * @property string $date_of_expense
 * @property string $expense_type
 * @property string $approval_type
 * @property string $user
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereApprovalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereDateOfExpense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereExpenseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereItemRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRequest whereUser($value)
 */
	class CashRequest extends \Eloquent {}
}

namespace App{
/**
 * App\Company
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $charge
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App{
/**
 * App\Contact
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App{
/**
 * App\CorporateOrder
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $address
 * @property string $rep_name
 * @property string $rep_number
 * @property string $rep_email
 * @property string $delivery_date
 * @property string $items
 * @property int|null $order_amount
 * @property string|null $order_status
 * @property string|null $payment_method
 * @property string|null $payment_status
 * @property string $channel
 * @property int|null $location_id
 * @property int|null $company_id
 * @property int|null $logistics_id
 * @property string|null $logistics
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Location|null $location
 * @property-read \App\Company|null $rider
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereLogistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereLogisticsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereRepEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereRepName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereRepNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CorporateOrder whereUpdatedAt($value)
 */
	class CorporateOrder extends \Eloquent {}
}

namespace App{
/**
 * App\Coupon
 *
 * @property int $id
 * @property string $code
 * @property string|null $type
 * @property int|null $value
 * @property int|null $percent_off
 * @property int|null $max_usage
 * @property string|null $payment_metadata
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $usage
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMaxUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon wherePaymentMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon wherePercentOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereValue($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App{
/**
 * App\DeliveryWindow
 *
 * @property int $id
 * @property string $day
 * @property string $start_time
 * @property string $end_time
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryWindow whereUpdatedAt($value)
 */
	class DeliveryWindow extends \Eloquent {}
}

namespace App{
/**
 * App\EventOrder
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $guests_count
 * @property \Illuminate\Support\Carbon $delivery_date
 * @property string $items
 * @property int|null $order_amount
 * @property string|null $order_status
 * @property string|null $payment_method
 * @property string|null $payment_status
 * @property string $channel
 * @property int $location_id
 * @property int|null $company_id
 * @property int|null $logistics_id
 * @property string|null $logistics
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Location $location
 * @property-read \App\Company|null $rider
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereGuestsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereLogistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereLogisticsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventOrder whereUpdatedAt($value)
 */
	class EventOrder extends \Eloquent {}
}

namespace App{
/**
 * App\Location
 *
 * @property int $id
 * @property string $delivery_location
 * @property int $delivery_charge
 * @property int|null $zone_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Zone|null $zone
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDeliveryCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDeliveryLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereZoneId($value)
 */
	class Location extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $billing_email
 * @property string|null $billing_name
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string $billing_state
 * @property string|null $billing_phone
 * @property int $billing_discount
 * @property string|null $billing_discount_code
 * @property int $billing_subtotal
 * @property int $billing_tax
 * @property int $billing_total
 * @property string|null $payment_ref
 * @property string|null $invoice_code
 * @property string $payment_gateway
 * @property string $payment_status
 * @property string $order_status
 * @property string $channel
 * @property int|null $vendor_id
 * @property int|null $location_id
 * @property int|null $company_id
 * @property int|null $logistics_id
 * @property string|null $logistics
 * @property \Illuminate\Support\Carbon|null $delivery_date
 * @property string|null $delivery_window
 * @property string $delivery_option
 * @property string|null $items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\DeliveryWindow|null $deliveryWindow
 * @property-read mixed $coupon
 * @property-read mixed $delivery_location_object
 * @property-read mixed $delivery_window_string
 * @property-read mixed $logistics_name
 * @property-read mixed $vendor_name
 * @property-read \App\Location|null $location
 * @property-read \App\Transaction|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Package[] $packages
 * @property-read int|null $packages_count
 * @property-read \App\Company|null $rider
 * @property-read \App\User|null $user
 * @property-read \App\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingDiscountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryWindow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInvoiceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLogistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLogisticsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereVendorId($value)
 */
	class Order extends \Eloquent {}
}

namespace App{
/**
 * App\OrderDate
 *
 * @property int $id
 * @property string $date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDate whereUpdatedAt($value)
 */
	class OrderDate extends \Eloquent {}
}

namespace App{
/**
 * App\OrderDay
 *
 * @property int $id
 * @property string $day
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDay whereUpdatedAt($value)
 */
	class OrderDay extends \Eloquent {}
}

namespace App{
/**
 * App\Package
 *
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string $description
 * @property string $content
 * @property string $type
 * @property string $status
 * @property string $product_image
 * @property string|null $featured_image
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_content
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereProductImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 */
	class Package extends \Eloquent {}
}

namespace App{
/**
 * App\PackageOrder
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PackageOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageOrder query()
 */
	class PackageOrder extends \Eloquent {}
}

namespace App{
/**
 * App\Setting
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App{
/**
 * App\Transaction
 *
 * @property int $id
 * @property int $order_id
 * @property string $transaction_ref
 * @property int $amount
 * @property string $channel
 * @property string $payment_ref
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePaymentRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $address_2
 * @property string|null $special_date
 * @property string|null $piggyvest_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $role
 * @property string|null $admin_role
 * @property string|null $location_id
 * @property string $password
 * @property string|null $remember_token
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $delivery_location
 * @property-read \App\Location|null $location
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $successOrders
 * @property-read int|null $success_orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdminRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePiggyvestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSpecialDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

namespace App{
/**
 * App\Vendor
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property int|null $contact_number
 * @property string|null $bank_name
 * @property int|null $account_number
 * @property string|null $account_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Zone[] $zone
 * @property-read int|null $zone_count
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereUpdatedAt($value)
 */
	class Vendor extends \Eloquent {}
}

namespace App{
/**
 * App\Zone
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Location[] $locations
 * @property-read int|null $locations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedAt($value)
 */
	class Zone extends \Eloquent {}
}

