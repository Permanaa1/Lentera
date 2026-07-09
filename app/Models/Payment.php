<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'payment_date', 'amount', 'payment_method',
        'transaction_number', 'proof_file_path', 'status',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function verifyPayment(bool $approved = true): bool
    {
        $this->update(['status' => $approved ? 'verified' : 'rejected']);

        if ($approved) {
            $this->invoice->markAsPaid();
        }

        return $approved;
    }
}
