<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. تحديد اسم الجدول الكبير كما في المايغريشن
    protected $table = 'USERS';

    // 2. المفتاح الأساسي المخصص
    protected $primaryKey = 'user_id';

    // 3. الحقول القابلة للتعبئة
    protected $fillable = [
        'full_name',
        'username', 
        'password',
        'email',
        'role',          // المطلب 5+6: التمييز بين manager و staff
        'warehouse_id',   // المطلب 7: تبعية الموظف لمستودع واحد
    ];

    // 4. الحقول المخفية
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // --- العلاقات (Relationships) ---

    /**
     * المطلب 7: تبعية الموظف لمستودع واحد
     * الموظف (staff) ينتمي لمستودع محدد للعمل فيه.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'warehouse_id');
    }

    /**
     * المطلب 5: علاقة المدير بالمستودع
     * المستخدم برتبة (manager) يشرف إدارياً على مستودع.
     */
    public function managedWarehouse()
    {
        return $this->hasOne(Warehouse::class, 'manager_id', 'user_id');
    }

    /**
     * دوال مساعدة للتحقق من الصلاحيات (Helper Methods)
     * ستفيدنا في الـ View لإخفاء أزرار الحذف عن الموظف
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }
}