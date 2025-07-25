<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoinGeckoTrending;
use Yajra\DataTables\Facades\DataTables as Datatables;

class TrendingsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.trendings');
    }

    public function getData()
    {
        return Datatables::of(CoinGeckoTrending::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 18px;'>
                           <input type='hidden' class='id' value='".strtolower($item->symbol)."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";

            })
            ->editColumn('small', function ($item) {
                return '<img src="'.$item->small.'" height=25 width=25 class="previewable-img">';
            })
            ->editColumn('price_btc', function ($item) {
                return "<p class='warning'>".$item->price_btc."</p>";
            })
            ->editColumn('data', function ($item) {
                if(empty($item->data)) {
                    return ' - ';
                }
                $json = json_decode($item->data, true);
                if (!$json || !is_array($json)) return ' - ';
                $iconMap = [
                    'twitter' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#1da1f2" style="vertical-align:middle;"><path d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 0 0 1.88-2.37 8.59 8.59 0 0 1-2.72 1.04A4.28 4.28 0 0 0 16.11 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99C7.69 9.13 4.07 7.38 1.64 4.7c-.37.64-.58 1.38-.58 2.17 0 1.5.76 2.82 1.92 3.6-.7-.02-1.36-.21-1.94-.53v.05c0 2.1 1.5 3.85 3.5 4.25-.36.1-.74.16-1.13.16-.28 0-.54-.03-.8-.08.54 1.7 2.1 2.94 3.95 2.97A8.6 8.6 0 0 1 2 19.54c-.32 0-.63-.02-.94-.06A12.13 12.13 0 0 0 8.29 21.5c7.55 0 11.68-6.26 11.68-11.68 0-.18-.01-.36-.02-.54A8.18 8.18 0 0 0 24 4.59a8.36 8.36 0 0 1-2.54.7z"/></svg>',
                    'reddit' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ff4500" style="vertical-align:middle;"><circle cx="12" cy="12" r="12" fill="#ff4500"/><ellipse cx="8.5" cy="13.5" rx="2.5" ry="2" fill="#fff"/><ellipse cx="15.5" cy="13.5" rx="2.5" ry="2" fill="#fff"/><circle cx="8.5" cy="13.5" r="1" fill="#000"/><circle cx="15.5" cy="13.5" r="1" fill="#000"/><ellipse cx="12" cy="16" rx="3" ry="1.2" fill="#000"/><circle cx="5.5" cy="8.5" r="1.2" fill="#fff"/><circle cx="18.5" cy="8.5" r="1.2" fill="#fff"/></svg>',
                    'website' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#43cea2" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#43cea2"/><path d="M2 12h20M12 2a10 10 0 0 1 0 20M12 2a10 10 0 0 0 0 20" stroke="#fff" stroke-width="2"/></svg>',
                    'github' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#333" style="vertical-align:middle;"><path d="M12 2C6.48 2 2 6.58 2 12.26c0 4.5 2.87 8.32 6.84 9.67.5.09.68-.22.68-.48 0-.24-.01-.87-.01-1.7-2.78.62-3.37-1.36-3.37-1.36-.45-1.18-1.1-1.5-1.1-1.5-.9-.63.07-.62.07-.62 1 .07 1.53 1.05 1.53 1.05.89 1.56 2.34 1.11 2.91.85.09-.66.35-1.11.63-1.37-2.22-.26-4.56-1.14-4.56-5.07 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.3.1-2.7 0 0 .84-.28 2.75 1.05A9.38 9.38 0 0 1 12 6.84c.85.004 1.7.12 2.5.35 1.9-1.33 2.74-1.05 2.74-1.05.55 1.4.2 2.44.1 2.7.64.72 1.03 1.63 1.03 2.75 0 3.94-2.34 4.8-4.57 5.06.36.32.68.95.68 1.92 0 1.39-.01 2.51-.01 2.85 0 .27.18.58.69.48A10.01 10.01 0 0 0 22 12.26C22 6.58 17.52 2 12 2z"/></svg>',
                    'telegram' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#0088cc" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#0088cc"/><path d="M8 12l2.5 2.5L16 8" stroke="#fff" stroke-width="2"/></svg>',
                    'facebook' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#1877f3" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#1877f3"/><path d="M13 8h2V6.5A1.5 1.5 0 0 0 13.5 5h-1A1.5 1.5 0 0 0 11 6.5V8H9v2h2v6h2v-6h2l.5-2H13V8z" fill="#fff"/></svg>',
                    'discord' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#7289da" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#7289da"/><ellipse cx="8.5" cy="13.5" rx="2.5" ry="2" fill="#fff"/><ellipse cx="15.5" cy="13.5" rx="2.5" ry="2" fill="#fff"/><circle cx="8.5" cy="13.5" r="1" fill="#7289da"/><circle cx="15.5" cy="13.5" r="1" fill="#7289da"/></svg>',
                    'medium' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#00ab6c" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#00ab6c"/><ellipse cx="12" cy="12" rx="6" ry="6" fill="#fff"/></svg>',
                    'youtube' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ff0000" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#ff0000"/><polygon points="10,8 16,12 10,16" fill="#fff"/></svg>',
                    'linkedin' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#0077b5" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#0077b5"/><rect x="8" y="10" width="2" height="6" fill="#fff"/><rect x="14" y="10" width="2" height="6" fill="#fff"/><circle cx="9" cy="8" r="1" fill="#fff"/><circle cx="15" cy="8" r="1" fill="#fff"/></svg>',
                    'email' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ff99ac" style="vertical-align:middle;"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>',
                    'explorer' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ffd200" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 7v5l4 2" stroke="#fff" stroke-width="2"/></svg>',
                    'whitepaper' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#bdbdbd" style="vertical-align:middle;"><rect x="4" y="4" width="16" height="16" rx="4" fill="#bdbdbd"/><path d="M8 12h8M8 16h4" stroke="#fff" stroke-width="2"/></svg>',
                    'blog' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ffb300" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#ffb300"/><rect x="8" y="8" width="8" height="8" fill="#fff"/></svg>',
                    'forum' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#43cea2" style="vertical-align:middle;"><rect x="4" y="4" width="16" height="16" rx="4" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#fff" stroke-width="2"/></svg>',
                    'chat' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#43cea2" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#fff" stroke-width="2"/></svg>',
                    'bitcointalk' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#f7931a" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#f7931a"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">₿</text></svg>',
                    'coinmarketcap' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#1867ff" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#1867ff"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">CMC</text></svg>',
                    'coingecko' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#8dc351" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#8dc351"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">CG</text></svg>',
                    'price' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ffd200" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#ffd200"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>',
                    'volume' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ff6a88" style="vertical-align:middle;"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ff6a88"/><path d="M8 16h2V8h2v8h2V8h2v8" stroke="#fff" stroke-width="2"/></svg>',
                    'rank' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ffd200" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#ffd200"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">#</text></svg>',
                    'score' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ff6a88" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#ff6a88"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">★</text></svg>',
                    'launch' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#43cea2" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#43cea2"/><path d="M12 8v8M8 12h8" stroke="#fff" stroke-width="2"/></svg>',
                    'contract' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#bdbdbd" style="vertical-align:middle;"><rect x="4" y="4" width="16" height="16" rx="4" fill="#bdbdbd"/><path d="M8 12h8M8 16h4" stroke="#fff" stroke-width="2"/></svg>',
                    'address' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#ff99ac" style="vertical-align:middle;"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>',
                    'status' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="#43cea2" style="vertical-align:middle;"><circle cx="12" cy="12" r="10" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#fff" stroke-width="2"/></svg>',
                ];
                $str = '<div style="display:flex;flex-wrap:wrap;gap:0.5em;">';
                foreach ($json as $key => $inner) {
                    $icon = $iconMap[strtolower($key)] ?? '';
                    $label = ucfirst($key);
                    $valueHtml = '';
                    if (is_array($inner)) {
                        $valueHtml = '<span style="display:inline-block;min-width:2em;">[';
                        $count = 0;
                        foreach ($inner as $v) {
                            if ($count >= 3) { $valueHtml .= '...'; break; }
                            $vShort = mb_strlen($v) > 40 ? '<span title="'.htmlspecialchars($v).'">'.htmlspecialchars(mb_substr($v,0,40)).'…</span>' : htmlspecialchars($v);
                            if (filter_var($v, FILTER_VALIDATE_URL)) {
                                $vShort = '<a href="'.htmlspecialchars($v).'" target="_blank" rel="noopener" style="color:#ff6a88;text-decoration:underline;">'.$vShort.'</a>';
                            }
                            $valueHtml .= ($count > 0 ? ', ' : '') . $vShort;
                            $count++;
                        }
                        $valueHtml .= ']</span>';
                    } else {
                        $v = $inner;
                        $vShort = mb_strlen($v) > 40 ? '<span title="'.htmlspecialchars($v).'">'.htmlspecialchars(mb_substr($v,0,40)).'…</span>' : htmlspecialchars($v);
                        if (filter_var($v, FILTER_VALIDATE_URL)) {
                            $vShort = '<a href="'.htmlspecialchars($v).'" target="_blank" rel="noopener" style="color:#ff6a88;text-decoration:underline;">'.$vShort.'</a>';
                        } elseif (is_bool($v) || $v === 'true' || $v === 'false' || $v === 1 || $v === 0) {
                            $isTrue = ($v === true || $v === 'true' || $v === 1 || $v === '1');
                            $vShort = '<span style="background:'.($isTrue?'#43cea2':'#ff6a88').';color:#fff;padding:0.1em 0.7em;border-radius:1em;font-size:0.95em;">'.($isTrue?'Yes':'No').'</span>';
                        }
                        $valueHtml = $vShort;
                    }
                    $str .= '<span style="background:#f7f7fa;border-radius:1.2em;padding:0.3em 0.9em;display:inline-flex;align-items:center;gap:0.4em;font-size:0.98em;box-shadow:0 1px 3px #eee;">'.$icon.'<span style="color:#ff6a88;font-weight:600;">'.$label.':</span> '.$valueHtml.'</span>';
                }
                $str .= '</div>';
                return $str;
            })
            ->rawColumns([
               //'name',
               // 'small',
                'price_btc',
               // 'data'
            ])
            ->make(true);
    }
}