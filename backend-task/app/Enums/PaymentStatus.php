<?php

namespace App\Enums;

enum PaymentStatus: string {
    case PENDING = 'pending';
    case PAID = 'success';
    case FAILED = 'failed';

    // Метод для вывода русского текста
    public function label(): string {
        return match($this) {
            self::PENDING => 'Ожидает оплаты',
            self::PAID => 'Оплачено',
            self::FAILED => 'Ошибка оплаты',
        };
    }
}