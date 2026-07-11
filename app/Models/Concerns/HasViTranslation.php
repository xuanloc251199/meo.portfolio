<?php

namespace App\Models\Concerns;

trait HasViTranslation
{
    /**
     * Giá trị của $field theo locale hiện tại: locale vi ưu tiên cột "{$field}_vi",
     * rỗng thì fallback về bản gốc (tiếng Anh).
     */
    public function tr(string $field): ?string
    {
        if (app()->getLocale() === 'vi') {
            $vi = $this->getAttribute($field.'_vi');

            if (filled($vi)) {
                return $vi;
            }
        }

        return $this->getAttribute($field);
    }
}
