<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CoursePaginatedCollection extends ResourceCollection
{
    public $collects = CourseResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'pagination' => [
                'total'    => $this->resource->lastPage(),
                'current'  => $this->resource->currentPage(),
                'per_page' => $this->resource->perPage(),
            ]
        ];
    }

    public function paginationInformation($request, $paginated, $default)
    {
        return $default['data'] ?? [];
    }
}
