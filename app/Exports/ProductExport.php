<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return Enumerable
     */
    public function collection(): Enumerable
    {
        return Product::with(['brand', 'category'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Brand',
            'Category',
            'Regular Price',
            'Sale Price',
            'Stock Status',
            'Status',
        ];
    }

    /**
     * @param mixed $product
     * @return array
     */
    public function map(mixed $product): array
    {
        return [
            $product->id,
            $product->name,
            $product->SKU,
            $product->brand?->name ?? 'N/A',
            $product->category?->name ?? 'N/A',
            $product->regular_price,
            $product->sale_price,
            $product->stock_status,
            $product->status ? 'Published' : 'Draft',
        ];
    }
}
