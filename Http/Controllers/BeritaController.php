<?php

namespace Modules\Berita\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\Berita\Entities\Berita;
use Modules\Berita\Entities\Kategori;
use Modules\Berita\Http\Requests\BeritaRequest;

class BeritaController extends Controller
{
    protected $title = 'Modul Berita';
    private $data;

    /**
     * Siapkan konstruktor controller
     * 
     * @param Berita $data
     * @param Kategori $kategori
     */
    public function __construct(Berita $data, Kategori $kategori) 
    {
        $this->data = $data;
        $this->kategori = $kategori;

        $this->toIndex = route('epanel.kategori.berita.index', request()->segment(4));
        $this->prefix = 'epanel.kategori';
        $this->view = 'berita::berita';

        $this->tCreate = "Data $this->title berhasil ditambah!";
        $this->tUpdate = "Data $this->title berhasil diubah!";
        $this->tDelete = "Beberapa data $this->title berhasil dihapus sekaligus!";

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
    public function index(Request $request, $kategori) 
    {
        if($kategori == 'uncategorized'):
            $kategori = 'Uncategorized';
            $data = $this->data->whereIdKategori(null)->latest()->get();
            $slug = 'uncategorized';
        else:
            $kategori = $this->kategori->slug($kategori)->firstOrFail();
            $data = $kategori->berita()->latest()->get();
            $slug = $kategori->slug;
        endif;

        if($request->has('datatable')):
            return $this->datatable($data, $slug);
        endif;

        return view("$this->view.index", compact('data', 'kategori', 'slug'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create($kategori) 
    {
        $kategori = $this->kategori->slug($kategori)->first();

        return view("$this->view.create", compact('kategori'));
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(BeritaRequest $request, $kategori) 
    {
        $kategori = $this->kategori->slug($kategori)->first();

        $input = $request->all();

        $input['id_operator'] = optional(auth()->user())->id;
        $input['komentar'] = $request->has('komentar') ? 1 : 0;
        $input['headline'] = $request->has('headline') ? 1 : 0;
        $input['id_kategori'] = $kategori ? $kategori->id : null;

        if($request->filled('tgl_terbit')):
            $input['created_at'] = date('Y-m-d H:i:s', strtotime($request->tgl_terbit));
        else:
            $input['created_at'] = \Carbon\Carbon::now();
        endif;

        if($request->hasFile('foto')):
            $input['foto'] = $this->upload($request->file('foto'), str_slug($request->judul));
        endif;

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
    public function show($kategori, $id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit(Request $request, $kategori, $id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        $kategori = $this->kategori->slug($kategori)->first();

        if($request->has('status')):
            $edit->update(['status' => $edit->status == 0 ? 1 : 0]);
            notify()->flash(__('berita::general.berita.changed'), 'success');
            return redirect()->back();
        endif;
    
        return view("$this->view.edit", compact('edit', 'kategori'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|View
     */
    public function update(BeritaRequest $request, $kategori, $id)
    {    
        $kategori = $this->kategori->slug($kategori)->first();

        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();
    
        $input['komentar'] = $request->has('komentar') ? 1 : 0;
        $input['headline'] = $request->has('headline') ? 1 : 0;

        if($request->filled('tgl_terbit')):
            $input['created_at'] = date('Y-m-d H:i:s', strtotime($request->tgl_terbit));
        endif;

        if($request->hasFile('foto')):
            deleteImg($edit->foto);
            $input['foto'] = $this->upload($request->file('foto'), str_slug($request->judul));
        else:
            $input['foto'] = $edit->foto;
        endif;
        
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
    public function destroy(Request $request, $kategori, $id)
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                deleteImg($each->foto);
                $each->delete();
            endforeach;

            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $tmpFilePath = 'app/public/Berita/';
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = $filename;
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;
        
        \Image::make($file->getRealPath())->resize(1024, null, function($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path() . "/$nama_file.$tmpFileExt");
        
        \Image::make($file->getRealPath())->fit(500, 500)->save(storage_path() . "/{$nama_file}_m.$tmpFileExt");
        \Image::make($file->getRealPath())->fit(100, 100)->save(storage_path() . "/{$nama_file}_s.$tmpFileExt");

        return "storage/Berita/{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
    } 

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data, $kategori) 
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
                $return  = $data->judul;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                $return .= '<i class="fa fa-tags"></i>  in <b>' . ($data->kategori ? $data->kategori->label : 'Uncategorized') . '</b>&nbsp;&nbsp;&nbsp;';
                if($data->komentar == 1):
                    $return .= '<span class="font-icon font-icon-comments active" data-toggle="tooltip" data-placement="top" data-original-title="Komentar: Aktif"></span>&nbsp;&nbsp;&nbsp;';
                endif;
                if($data->headline == 1):
                    $return .= '<span class="font-icon font-icon-lamp active" data-toggle="tooltip" data-placement="top" data-original-title="Headline: Aktif"></span>';
                endif;
                $return .= '</div>';
                return $return;
            })
            ->editColumn('views', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Hit(s)</div>';
                $return .= $data->view . ' View(s)';
                return $return;
            })
            ->editColumn('published', function($data) use ($kategori) {
                $return  = '<div class="btn-toolbar">';
                if($data->status == 1):
                    $return .= '    <div class="btn-group btn-group-sm">';
                    $return .= '        <a href="'. route("$this->prefix.berita.edit", [$kategori, $data->uuid]) .'?status=true" class="btn btn-sm btn-success">';
                    $return .= '            <span class="fa fa-check"></span>';
                    $return .= '        </a>';
                    $return .= '    </div>';
                    $return .= '</div>';
                else:
                    $return .= '    <div class="btn-group btn-group-sm">';
                    $return .= '        <a href="'. route("$this->prefix.berita.edit", [$kategori, $data->uuid]) .'?status=true" class="btn btn-sm btn-danger">';
                    $return .= '            <span class="fa fa-times"></span>';
                    $return .= '        </a>';
                    $return .= '    </div>';
                    $return .= '</div>';
                endif;
                return $return;
            })
            ->editColumn('tanggal', function($data) {
                \Carbon\Carbon::setLocale('id');
                $return  = '<small>' . date('Y-m-d h:i:s', strtotime($data->created_at)) . '</small><br/>';
                $return .= str_replace('yang ', '', $data->created_at->diffForHumans());
                return $return;
            })
            ->editColumn('oleh', function($data) {
                return '<img src="' . \Avatar::create(optional($data->operator)->nama)->toBase64() . '" data-toggle="tooltip" data-placement="top" data-original-title="Posted by ' . optional($data->operator)->nama . '">';
            })
            ->editColumn('aksi', function($data) use ($kategori) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.berita.edit", [$kategori, $data->uuid]) .'" role="button" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'label', 'published', 'views', 'tanggal', 'oleh', 'aksi'])->toJson();
    }
}
