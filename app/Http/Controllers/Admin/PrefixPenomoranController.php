<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pengaturan\PrefixPenomoranRequest;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;

class PrefixPenomoranController extends Controller
{
    /**
     * Prefix Penomoran Repository
     *
     * @var PrefixPenomoranRepository
     */
    private $prefix;

    /**
     * Constructor.
     */
    public function __construct(PrefixPenomoranRepository $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Prefix penomoran index.
     *
     * @return void
     */
    public function index()
    {
        $prefixs = $this->prefix->get();
        return view('admin.prefix_penomoran.index', compact('prefixs'));
    }

    /**
     * Update prefix penomoran.
     *
     * @return void
     */
    public function update(PrefixPenomoranRequest $request)
    {
        $this->prefix->update([
            'formulir' => $request->formulir,
            'format_penomoran' => $request->format
        ], $request->id);

        return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
    }
}
