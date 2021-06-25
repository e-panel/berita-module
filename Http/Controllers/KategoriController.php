<?php

namespace Modules\Berita\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\Berita\Entities\Kategori;
use Modules\Berita\Http\Requests\KategoriRequest;

class KategoriController extends Controller
{
    protected $title;

    /**
     * Siapkan konstruktor controller
     * 
     * @param Kategori $data
     */
    public function __construct(Kategori $data) 
    {
        $this->title = __('berita::general.kategori.title');
        $this->data = $data;

        $this->toIndex = route('epanel.kategori.index');
        $this->prefix = 'epanel.kategori';
        $this->view = 'berita::kategori';

        $this->tCreate = __('berita::general.kategori.created', ['title' => $this->title]);
        $this->tUpdate = __('berita::general.kategori.updated', ['title' => $this->title]);
        $this->tDelete = __('berita::general.kategori.deleted', ['title' => $this->title]);

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    /**
     * Tampilkan halaman utama modul yang dipilih
     * 
     * @param Request $request
     * @return Response|View
     */
    public function index(Request $request) 
    {
        $data = $this->data->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("$this->view.index", compact('data'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create() 
    {
        return view("$this->view.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(KategoriRequest $request) 
    {
        $input = $request->all();
        $this->data->create($input);
        
        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param Int $id
     * @return Response|View
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit($id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();
    
        return view("$this->view.edit", compact('edit'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|View
     */
    public function update(KategoriRequest $request, $id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();
        $edit->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|String
     */
    public function destroy(Request $request, $id)
    {
        if($request->has('pilihan')):

            foreach($request->pilihan as $temp):
                $data = $this->data->uuid($temp)->firstOrFail();
                foreach($data->berita as $side):
                    $side->update(['id_kategori' => null]);
                endforeach;
                $data->delete();
            endforeach;
            
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                $return  = '<span>';
                $return .= '    <div class="checkbox checkbox-only">';
                $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
                $return .= '        <label for="pilihan['.$data->id.']"></label>';
                $return .= '    </div>';
                $return .= '</span>';
                return $return;
            })
            ->editColumn('label', function($data) {
                $return  = $data->label;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                $return .= '    <a href="'.route('frontend.berita.kategori', $data->slug).'" target="_blank"><i class="fa fa-link"></i> Visit Link</a>';
                $return .= '</div>';
                return $return;
            })
            ->editColumn('total', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Total</div>';
                $return .= $data->berita->count() . ' Post(s)';
                return $return;
            })
            ->editColumn('tanggal', function($data) {
                \Carbon\Carbon::setLocale('id');
                $return  = '<small>' . date('Y-m-d h:i:s', strtotime($data->created_at)) . '</small><br/>';
                $return .= str_replace('yang ', '', $data->created_at->diffForHumans());
                return $return;
            })
            ->editColumn('aksi', function($data) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.edit", $data->uuid) .'" role="button" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'label', 'total', 'tanggal', 'aksi'])->toJson();
    }
}
