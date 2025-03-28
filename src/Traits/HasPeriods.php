<?php

namespace PittacusW\DatabaseManager\Traits;

trait HasPeriods {

  public function scopeYears($query) {
    return $query->select('yearPeriodo')
                 ->distinct()
                 ->orderBy('yearPeriodo', 'desc')
                 ->get()
                 ->pluck('yearPeriodo')
                 ->values();
  }

  public function scopeMonths($query, $year) {
    return $query->select('mesPeriodo')
                 ->where('yearPeriodo', ($year ?? date('Y')))
                 ->distinct()
                 ->get()
                 ->pluck('mesPeriodo')
                 ->sort()
                 ->values();
  }
}