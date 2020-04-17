<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TariffCreateRequest;
use App\Http\Requests\Admin\TariffEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Nikservik\Subscriptions\Models\Tariff;

class TariffController extends Controller
{

    static function routes()
    {
        Route::domain('admin.'.Str::after(config('app.url'),'//'))->namespace('Admin')->group(function () {
            Route::get('tariffs/{tariff}/default', 'TariffController@default')->middleware('can:update,tariff');
            Route::resource('tariffs', 'TariffController');
        });
    }

    public function __construct()
    {
        $this->middleware(['auth:web', 'isAdmin']);
        $this->authorizeResource(Tariff::class, 'tariff');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tariffs = Tariff::all();
        return view('admin.tariffs.list', ['tariffs' => $tariffs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tariffs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TariffCreateRequest $request)
    {
        $request->merge(array('prolongable' => $request->has('prolongable') ? true : false));
        $tariff = Tariff::create(array_merge(['name' => 'name'], $request->all()));

        foreach (config('app.locales') as $locale) {
            $tariff->setNameTranslation($request->get('name_'.$locale), $locale);
        }
        $tariff->visible = $request->has('visible') ? true : false;
        $tariff->features = $request->features;
        $tariff->save();

        return redirect('/tariffs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriptions\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        return view('admin.tariffs.show', ['tariff' => $tariff]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriptions\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        return view('admin.tariffs.edit', ['tariff' => $tariff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscriptions\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(TariffEditRequest $request, Tariff $tariff)
    {
        $request->merge(array('prolongable' => $request->has('prolongable') ? true : false));
        $tariff->fill($request->all());
        foreach (config('app.locales') as $locale) {
            $tariff->setNameTranslation($request->get('name_'.$locale), $locale);
        }
        $tariff->features = $request->features;
        $tariff->visible = $request->has('visible') ? true : false;
        $tariff->save();
        
        return redirect('/tariffs/'.$tariff->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriptions\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tariff $tariff)
    {
        $tariff->delete();
        return redirect('/tariffs');
    }

    public function default(Tariff $tariff)
    {
        if ($tariff->price > 0) 
            return redirect('/tariffs');

        $tariffs = Tariff::all();
        foreach ($tariffs as $eachTariff) {
            $eachTariff->default = ($eachTariff->id == $tariff->id) ? true : false;
            $eachTariff->save();
        }

        return redirect('/tariffs');
    }
}
