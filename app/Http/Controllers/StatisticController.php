<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StatisticController extends Controller
{
    // public function searchByCef($cef)
    // {
    //     $statistic=Statistic::with('stagiaire')
    //                ->when(request('search'), function($query, $search) {
    //                 $query->where('CEF','like',"%{$search}%");
    //                 // ->orWhere('description', 'like', "%{$search}%");
    //              //   ->orWhere('code', 'like', "%{$search}%");
    //         })
    //         ->paginate(5);
    //     //     $query->where('CEF','like',"%{$cef}%");
    //     // })->paginate(5);
    //     return response()->json(['statistic'=>$statistic]);

    // }

public function searchByCef($cef = null)
{
    $query = Statistic::with(['stagiaire.user', 'certificat', 'user'])
            ->where('type_cerf','diploma');

    if (!empty($cef)) {
        $query->whereHas('stagiaire', function ($q) use ($cef) {
            $q->where('CEF', 'like', "%{$cef}%");
        });
    }

    $statistics = $query->paginate(5);

    return response()->json([
        'statistic' => $statistics->items(),
        'pagination_html' => $statistics->links('pagination::bootstrap-4')->toHtml()
    ]);
}

public function searchByCefBac($cef = null)
{
    $query = Statistic::with(['stagiaire.user', 'certificat', 'user'])
            ->where('type_cerf','bac');

    if (!empty($cef)) {
        $query->whereHas('stagiaire', function ($q) use ($cef) {
            $q->where('CEF', 'like', "%{$cef}%");
        });
    }

    $statistics = $query->paginate(5);

    return response()->json([
        'statistic' => $statistics->items(),
        'pagination_html' => $statistics->links('pagination::bootstrap-4')->toHtml()
    ]);
}


// public function filtrage(Request $request)
// {
//     //  $validated = $request->validate([
//        //      "sector"    => ['required'],
//        //      "branch"    => ['required'],
//        //      "group"     => ['required'],
//        //      "status"    => ['required', Rule::in(['all', 'delivered', 'undelivered'])],
//        //      "type_date" => [
//        //          Rule::requiredIf(function () use ($request) {
//        //              return in_array($request->status, ['all', 'delivered']);
//        //          }),
//        //      ],
//        //      "date" => [
//        //          Rule::requiredIf(function () use ($request) {
//        //              return in_array($request->status, ['all', 'delivered']);
//        //          }),
//        //      ],
//        //  ]);
//     $validated = $request->validate([
//         "sector"    => ['required'],
//         "branch"    => ['required'],
//         "group"     => ['required'],
//         "status"    => ['required'],
//         "type_date" => ['required_if:status,delivered'],
//         "date"      => ['required_if:status,delivered'],
//     ]);

//     $query = Statistic::with('stagiaire.user', 'certificat', 'user')
//         ->whereHas('stagiaire.group.filier.secteur', function ($q) use ($validated) {
//             $q->where('id', $validated['sector']);
//         })
//         ->whereHas('stagiaire.group.filier', function ($q) use ($validated) {
//             $q->where('id', $validated['branch']);
//         })
//         ->whereHas('stagiaire.group', function ($q) use ($validated) {
//             $q->where('id', $validated['group']);
//         });

  
//         $query->whereHas('certificat', function ($q) use ($validated) {
//         $q->where('status', $validated['status']);
//         });
    

//     // Example for date filtering
//    $date = Carbon::parse($validated['date']);

//     if ($validated['type_date'] === 'month') {
//         $query->whereMonth('taken_date', $date->month)
//               ->whereYear('taken_date', $date->year);
    
//     } elseif ($validated['type_date'] === 'year') {
//         $query->whereYear('taken_date', $date->year);
    
//     } else {
//         $query->whereDate('taken_date', $date->toDateString());
//     }


//     $statistics = $query->get();

//     return response()->json($statistics);
// }

  public function filtrage(Request $request)
{
    $validated = $request->validate([
        'sector'    => ['required'],
        'branch'    => ['required'],
        'group'     => ['required'],
        'status'    => ['required', Rule::in(['delivered', 'undelivered'])],
        'type_date' => ['required_if:status,delivered'],
        'date'      => ['required_if:status,delivered'],
    ]);

    $query = Statistic::with(['stagiaire.user', 'certificat', 'user'])
        // ->whereHas('stagiaire.group.filier.secteur', fn($q) => $q->where('id', $validated['sector']))
        // ->whereHas('stagiaire.group.filier', fn($q) => $q->where('id', $validated['branch']))
        ->whereHas('stagiaire.group', fn($q) => $q->where('id', $validated['group']))
        ->whereHas('certificat', fn($q) => $q->where('status', $validated['status']));
        
    $query->where("type_cerf",'diploma');
   
    if ($validated['status'] === 'delivered') {
        $date = Carbon::parse($validated['date']);

        if ($validated['type_date'] === 'month') {
            $query->whereMonth('taken_date', $date->month)
                  ->whereYear('taken_date', $date->year);
        } elseif ($validated['type_date'] === 'year') {
            $query->whereYear('taken_date', $date->year);
        } else {
            $query->whereDate('taken_date', $date->toDateString());
        }
    }

    $statistics = $query->paginate(3);

    return response()->json([
        'statistic' => $statistics->items(),
         'pagination_html' => $statistics->links('pagination::bootstrap-4')->toHtml(),
    ]);

}


  public function filtrageBacs(Request $request)
{
    // $validated = $request->validate([
    //     'sector'    => ['required'],
    //     'branch'    => ['required'],
    //     'group'     => ['required'],
    //     'status'    => ['required', Rule::in(['delivered', 'undelivered','reserved'])],
    //     'type_date' => ['required_if:status,delivered'],
    //     'date'      => ['required_if:status,delivered'],
    // ]);


    $validated = $request->validate([
        'sector'    => ['required'],
        'branch'    => ['required'],
        'group'     => ['required'],
        'status'    => ['required', Rule::in(['delivered', 'undelivered', 'reserved'])],
        'type_date' => ['required_if:status,delivered', 'required_if:status,reserved'],
        'date'      => ['required_if:status,delivered', 'required_if:status,reserved'],
    ]);

    $query = Statistic::with(['stagiaire.user', 'certificat', 'user'])
        // ->whereHas('stagiaire.group.filier.secteur', fn($q) => $q->where('id', $validated['sector']))
        // ->whereHas('stagiaire.group.filier', fn($q) => $q->where('id', $validated['branch']))
        ->whereHas('stagiaire.group', fn($q) => $q->where('id', $validated['group']))
        ->whereHas('certificat', fn($q) => $q->where('status', $validated['status']));

    $query->where('type_cerf','bac');
   
    if ($validated['status'] === 'delivered' || $validated['status'] ==='reserved' ) {
        $date = Carbon::parse($validated['date']);

        if ($validated['type_date'] === 'month') {
            $query->whereMonth('taken_date', $date->month)
                  ->whereYear('taken_date', $date->year);
        } elseif ($validated['type_date'] === 'year') {
            $query->whereYear('taken_date', $date->year);
        } else {
            $query->whereDate('taken_date', $date->toDateString());
        }
    }

    $statistics = $query->paginate(3);

    return response()->json([
        'statistic' => $statistics->items(),
        'pagination_html' => $statistics->links('pagination::bootstrap-4')->toHtml()
    ]);
  
}
}
