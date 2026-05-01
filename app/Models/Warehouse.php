<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    // 1. تحديد اسم الجدول كما في المايغريشن (WAREHOUSE)
    protected $table = 'WAREHOUSE';

    // 2. المفتاح الأساسي
    protected $primaryKey = 'warehouse_id';

    // 3. تفعيل التوقيت (timestamps)
    public $timestamps = true;

    /**
     * 4. الحقول القابلة للتعبئة
     * المطلب 2: أضفنا price (عشري)
     * المطلب 6: أضفنا staff_id (الموظف المسؤول)
     */
    protected $fillable = [
        'warehouse_name', 
        'city',
        'brochure',     // المطلب 1: ملف المواصفات (يرفعه الموظف)
        'price',        // المطلب 2: السعر العشري
        'store_id',     // المطلب 4: التبعية للمتجر (اختياري)
        'manager_id',   // المطلب 5: المدير المسؤول
        'staff_id'      // المطلب 6: الموظف المسؤول
    ];

    // --- العلاقات (Relationships) ---

    /**
     * المطلب 4: التبعية للمتجر (اختياري)
     * يسمح بربط المستودع بمتجر، ويقبل القيمة null.
     */
    

    /**
     * المطلب 5: علاقة المستودع بالمدير
     * المدير هو الذي يملك صلاحية "الحذف المشروط".
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'user_id');
    }

    /**
     * المطلب 6: علاقة المستودع بالموظف المسؤول
     * الموظف هو الذي يقوم بإدخال وتعديل البيانات (بما فيها البروشور).
     */
    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'user_id');
    }

    /**
     * المطلب 7: جلب جميع الموظفين التابعين لهذا المستودع
     */
    public function staffMembers()
    {
        return $this->hasMany(User::class, 'warehouse_id', 'warehouse_id');
    }

    /**
     * علاقة الجرد (Many-to-Many)
     * لجلب الساعات وكمياتها لعرضها في الـ GridView.
     */
  // علاقة المتجر (تأكد أن اسمها store بالمفرد لأن المستودع يتبع لمتجر واحد)
public function store()
{
    return $this->belongsTo(Store::class, 'store_id', 'store_id');
}

// علاقة المنتجات (جمع لأنها متعدد لمتعدد)
public function products()
{
    return $this->belongsToMany(Product::class, 'WAREHOUSE_PRODUCT', 'warehouse_id', 'product_id')
                ->withPivot('quantity')
                ->withTimestamps();
}

    /**
     * المطلب 4: التحقق من التبعية (للحذف المشروط)
     * تستخدم في الـ Controller للتأكد من عدم وجود منتجات قبل الحذف.
     */
    public function directProducts()
    {
        return $this->hasMany(Product::class, 'warehouse_id', 'warehouse_id');
    }
}