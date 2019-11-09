<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('usort_created', [$this, 'usortByCreatedFilter']),
        ];
    }

    public function usortByCreatedFilter($item)
    {
        usort($item, function ($item1, $item2) {
            if ($item1->createdAt === $item2->createdAt) {
                return 0;
            }

            return $item1->createdAt < $item2->createdAt ? -1 : 1;
        });

        return $item;
    }
}
