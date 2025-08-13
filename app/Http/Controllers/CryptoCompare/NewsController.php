<?php

namespace App\Http\Controllers\CryptoCompare;

use App\Http\Controllers\Controller;
use App\Models\CryptoCompare\CryptoCompareNews;
use Yajra\DataTables\Facades\DataTables as Datatables;

class NewsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cryptocompare.news');
    }

    public function getData()
    {
        return Datatables::of(CryptoCompareNews::all())
            ->editColumn('title', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->news_id."'/>
                           <p class='success'>".$item->title ."</p>
                        </span>";
            })
            ->editColumn('source', function ($item) {
                return "<p class='warning'>".$item->source."</p>";
            })
            ->editColumn('published_on', function ($item) {
                return $item->published_on ? $item->published_on->format('Y-m-d H:i:s') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('imageurl', function ($item) {
                if ($item->imageurl) {
                    return '<img src="https://www.cryptocompare.com/'.$item->imageurl.'" height=50 width=50 class="previewable-img">';
                }
                return '<span class="text-muted">No image</span>';
            })
            ->editColumn('url', function ($item) {
                if ($item->url) {
                    return '<a href="'.$item->url.'" target="_blank" class="text-primary">Read Article</a>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('body', function ($item) {
                if ($item->body) {
                    $short = strlen($item->body) > 150 ? substr($item->body, 0, 150) . '...' : $item->body;
                    return '<span title="'.$item->body.'">'.$short.'</span>';
                }
                return '<span class="text-muted">No content</span>';
            })
            ->editColumn('tags', function ($item) {
                if ($item->tags) {
                    $tags = explode(',', $item->tags);
                    $short = implode(', ', array_slice($tags, 0, 3));
                    if (count($tags) > 3) {
                        $short .= '...';
                    }
                    return '<span title="'.$item->tags.'">'.$short.'</span>';
                }
                return '<span class="text-muted">No tags</span>';
            })
            ->editColumn('categories', function ($item) {
                if ($item->categories) {
                    $categories = explode(',', $item->categories);
                    $short = implode(', ', array_slice($categories, 0, 2));
                    if (count($categories) > 2) {
                        $short .= '...';
                    }
                    return '<span title="'.$item->categories.'">'.$short.'</span>';
                }
                return '<span class="text-muted">No categories</span>';
            })
            ->editColumn('upvotes', function ($item) {
                if ($item->upvotes) {
                    return "<p class='success'>".number_format($item->upvotes, 0, ',', ' ')."</p>";
                }
                return '<span class="text-muted">0</span>';
            })
            ->editColumn('downvotes', function ($item) {
                if ($item->downvotes) {
                    return "<p class='danger'>".number_format($item->downvotes, 0, ',', ' ')."</p>";
                }
                return '<span class="text-muted">0</span>';
            })
            ->editColumn('lang', function ($item) {
                return $item->lang ? strtoupper($item->lang) : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('guid', function ($item) {
                if ($item->guid) {
                    return '<span class="text-muted" style="font-size: 12px;">'.substr($item->guid, 0, 20).'...</span>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('source_info', function ($item) {
                if ($item->source_info) {
                    $sourceInfo = json_decode($item->source_info, true);
                    if (is_array($sourceInfo) && isset($sourceInfo['name'])) {
                        return '<span class="text-info">'.$sourceInfo['name'].'</span>';
                    }
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->rawColumns([
                'title',
                'source',
                'published_on',
                'imageurl',
                'url',
                'body',
                'tags',
                'categories',
                'upvotes',
                'downvotes',
                'lang',
                'guid',
                'source_info'
            ])
            ->make(true);
    }
} 