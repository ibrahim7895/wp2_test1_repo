<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    // 1. تحديد اسم الجدول كما هو في المايغريشن (STORES)
    protected $table = 'STORES';

    // 2. المفتاح الأساسي
    protected $primaryKey = 'store_id';

    /**
     * 3. الحقول القابلة للتعبئة
     * المطلب 2: أضفنا حقل price ليتوافق مع الداتا بيز (Decimal)
     */
    protected $fillable = [
        'store_name', 
        'location', 
        'price'
    ];

    // --- العلاقات (Relationships) ---

    /**
     * المطلب 4: علاقة One-to-Many
     * المتجر الواحد يمكن أن يتبعه عدة مستودعات (وهذا مسموح حسب طلبك)
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'store_id', 'store_id');
    }
    
}