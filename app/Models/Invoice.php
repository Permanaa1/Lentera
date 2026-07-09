<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['student_id', 'invoice_type', 'amount', 'due_date', 'status'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ================= Method (sesuai class diagram) =================

    public static function generateInvoice(int $studentId, string $type, float $amount, string $dueDate): self
    {
        return static::create([
            'student_id' => $studentId,
            'invoice_type' => $type,
            'amount' => $amount,
            'due_date' => $dueDate,
            'status' => 'unpaid',
        ]);
    }

    public function markAsPaid(): bool
    {
        return $this->update(['status' => 'paid']);
    }
}
