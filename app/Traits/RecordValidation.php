<?php

namespace App\Traits;

trait RecordValidation {
    
    protected function recordRules() {
        return [
            'name' => 'required|string',
            'account' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|string',
            'checked' => 'nullable|boolean',
            'email' => 'nullable|email',
            'interest' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
            'credit_card' => 'required|array',
            'credit_card.name' => 'required|string',
            'credit_card.number' => 'required|string',
            'credit_card.expirationDate' => 'required|string',
            'credit_card.type' => 'required|string',
        ];
    }
}