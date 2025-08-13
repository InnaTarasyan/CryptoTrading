<?php

namespace App\Http\Controllers\CryptoCompare;

use App\Http\Controllers\Controller;
use App\Models\CryptoCompare\CryptoCompareExchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cryptocompare.exchanges');
    }

    public function getData()
    {
        return Datatables::of(CryptoCompareExchanges::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->name."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";
            })
            ->editColumn('internal_name', function ($item) {
                return "<p class='warning'>".$item->internal_name."</p>";
            })
            ->editColumn('logo_url', function ($item) {
                if ($item->logo_url) {
                    return '<img src="https://www.cryptocompare.com/'.$item->logo_url.'" height=50 width=50 class="previewable-img">';
                }
                return '<span class="text-muted">No logo</span>';
            })
            ->editColumn('url', function ($item) {
                if ($item->url) {
                    return '<a href="'.$item->url.'" target="_blank" class="text-primary">Visit</a>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('country', function ($item) {
                return $item->country ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('centralized', function ($item) {
                return $item->centralized ? '<span class="badge badge-info">Centralized</span>' : '<span class="badge badge-warning">Decentralized</span>';
            })
            ->editColumn('grade', function ($item) {
                if ($item->grade) {
                    $class = 'badge badge-secondary';
                    if (in_array($item->grade, ['AA', 'A'])) {
                        $class = 'badge badge-success';
                    } elseif (in_array($item->grade, ['BB', 'B'])) {
                        $class = 'badge badge-warning';
                    } elseif (in_array($item->grade, ['CC', 'C', 'D', 'E', 'F'])) {
                        $class = 'badge badge-danger';
                    }
                    return "<span class='$class'>".$item->grade."</span>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('grade_points', function ($item) {
                if ($item->grade_points) {
                    $class = 'text-muted';
                    if ($item->grade_points >= 80) {
                        $class = 'text-success';
                    } elseif ($item->grade_points >= 60) {
                        $class = 'text-warning';
                    } elseif ($item->grade_points < 60) {
                        $class = 'text-danger';
                    }
                    return "<span class='$class'>".number_format($item->grade_points, 2, ',', ' ')."</span>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('sort_order', function ($item) {
                return $item->sort_order ? number_format($item->sort_order, 0, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('sponsored', function ($item) {
                return $item->sponsored ? '<span class="badge badge-warning">Sponsored</span>' : '<span class="badge badge-secondary">No</span>';
            })
            ->editColumn('recommended', function ($item) {
                return $item->recommended ? '<span class="badge badge-success">Recommended</span>' : '<span class="badge badge-secondary">No</span>';
            })
            ->editColumn('description', function ($item) {
                if ($item->description) {

                    $max_length = 100;

                    if (mb_strlen($item->description, 'UTF-8') > $max_length) {
                        $short = mb_substr($item->description, 0, $max_length, 'UTF-8') . '...';
                    } else {
                        $short = $item->description;
                    }

                    return '<span title="'.$item->description.'">'.$short.'</span>';
                }
                return '<span class="text-muted">No description</span>';
            })
            ->editColumn('data_symbols_count', function ($item) {
                return $item->data_symbols_count ? number_format($item->data_symbols_count, 0, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('volume_1hrs_usd', function ($item) {
                if ($item->volume_1hrs_usd) {
                    return "<p class='warning'>".number_format((float)$item->volume_1hrs_usd, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('volume_1day_usd', function ($item) {
                if ($item->volume_1day_usd) {
                    return "<p class='success'>".number_format((float)$item->volume_1day_usd, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('volume_1mth_usd', function ($item) {
                if ($item->volume_1mth_usd) {
                    return "<p class='danger'>".number_format((float)$item->volume_1mth_usd, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('item_type', function ($item) {
                if ($item->item_type) {
                    $types = json_decode($item->item_type, true);
                    if (is_array($types)) {
                        return implode(', ', $types);
                    }
                    return $item->item_type;
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('features', function ($item) {
                if ($item->features) {
                    $features = json_decode($item->features, true);
                    if (is_array($features) && count($features) > 0) {
                        $short = implode(', ', array_slice($features, 0, 3));
                        if (count($features) > 3) {
                            $short .= '...';
                        }
                        return '<span title="'.implode(', ', $features).'">'.$short.'</span>';
                    }
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->rawColumns([
                'name',
                'internal_name',
                'logo_url',
                'url',
                'country',
                'centralized',
                'grade',
                'grade_points',
                'sort_order',
                'sponsored',
                'recommended',
                'description',
                'data_symbols_count',
                'volume_1hrs_usd',
                'volume_1day_usd',
                'volume_1mth_usd',
                'item_type',
                'features'
            ])
            ->make(true);
    }
} 