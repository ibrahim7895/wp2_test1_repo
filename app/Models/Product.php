<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // 1. تحديد اسم الجدول كما في المايغريشن (PRODUCT)
    protected $table = 'PRODUCT';

    // 2. المفتاح الأساسي
    protected $primaryKey = 'product_id';

    // 3. تفعيل التوقيت (timestamps)
    public $timestamps = true;

    /**
     * 4. الحقول القابلة للتعبئة
     * المطلب 2: حقل price سيتعامل مع القيم العشرية (Decimal)
     */
    protected $fillable = [
        'product_name', 
        'upload_file', 
        'price', 
        'description',
        'warehouse_id' // المفتاح الأجنبي لشرط الحذف (Restrict)
    ];

    // --- العلاقات (Relationships) ---

    /**
     * المطلب 4: علاقة التبعية (BelongsTo)
     * المنتج ينتمي لمستودع أساسي، وهذا الرابط هو الذي يمنع المدير من حذف المستودع
     * إذا كانت هناك ساعات مرتبطة به (Restrict).
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'warehouse_id');
    }

    /**
     * المطلب 3: علاقة الجرد والكميات (Many-to-Many)
     * تستخدم لعرض الكميات في الـ GridView وتسمح للموظف بتعديلها عبر الجدول الوسيط.
     */
    public function warehouses()
    {
        return $this->belongsToMany(
            Warehouse::class, 
            'WAREHOUSE_PRODUCT', 
            'product_id', 
            'warehouse_id'
        )->withPivot('quantity')->withTimestamps();
    }
}