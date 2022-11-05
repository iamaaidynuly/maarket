<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUsBlockImage;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Storage;
use App\Models\AboutUsBlock;
use App\Models\Translate;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class AboutUsBlockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $slug = $request->get('slug');
        $abouts = AboutUsBlock::where('slug', $slug)->get();

        return view('about.index', compact('abouts', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('about.create');
    }

    public function edit($id)
    {
        $aboutusblock = AboutUsBlock::find($id);
        $images = AboutUsBlockImage::where('about_us_block_id', $id)->get();

        return view('about.edit', compact(
            'aboutusblock',
            'images',
        ));
    }

    public function update(Request $request, $id)
    {
        $about = AboutUsBlock::find($id);
        Translate::find($about->title)->update([
            'ru' => $request['title']['ru'],
            'kz' => $request['title']['kz'],
            'en' => $request['title']['en'],
        ]);
        Translate::find($about->description)->update([
            'ru' => $request['content']['ru'],
            'kz' => $request['content']['kz'],
            'en' => $request['content']['en'],
        ]);

        if ($request->hasFile('image')) {
            if ($about->image_mobile != null) {
                Storage::disk('static')->delete($about->image_mobile);
            }
            $name = time() . '.' . $request['image']->extension();
            $path = 'aboutusblock';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
        }

        $about->update([
            'url' => $request['url'] ?? $about->url,
            'image' => $requestData['image'] ?? $about->image,
        ]);
        if (isset($request['additional_images'])) {
            if (AboutUsBlockImage::where('about_us_block_id', $about->id)->exists()) {
                AboutUsBlockImage::where('about_us_block_id', $about->id)->delete();
            }
            foreach ($request['additional_images'] as $item) {
                $name = time() . '.' . $item->extension();
                $path = 'aboutusblock';
                $item = $item->storeAs($path, $name, 'static');

                AboutUsBlockImage::insert([
                    'about_us_block_id' => $about->id,
                    'image' => $item,
                ]);
            }
        }


        return redirect('admin/about-us-block?slug=' . $request['slug'])->with('flash_message', 'Сохранено');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        $title = new Translate();
        $title->ru = $requestData['title']['ru'];
        $title->kz = $requestData['title']['kz'];
        $title->en = $requestData['title']['en'];
        $title->save();

        $description = new Translate();
        $description->ru = $requestData['content']['ru'];
        $description->kz = $requestData['content']['kz'];
        $description->en = $requestData['content']['en'];
        $description->save();

        if ($request->hasFile('image')) {
            $name = time() . '.' . $requestData['image']->extension();
            $path = 'aboutusblock';
            $requestData['image'] = $request->file('image')->storeAs($path, $name, 'static');
            $image = $requestData['image'];
        }

        $about = AboutUsBlock::create([
            'title' => $title->id,
            'description' => $description->id,
            'slug' => $request['type'],
            'url' => $request['url'] ?? null,
            'image' => $image ?? null,
            'image_mobile' => $imageMobile ?? null,
        ]);

        if (empty($request['additional_images'])) {
            foreach ($requestData['additional_images'] as $item) {
                $name = time() . '.' . $item->extension();
                $path = 'aboutusblock';
                $item = $item->storeAs($path, $name, 'static');

                AboutUsBlockImage::insert([
                    'about_us_block_id' => $about->id,
                    'image' => $item,
                ]);
            }
        }

        return redirect('admin/about-us-block?slug=' . $about['slug'])->with('flash_message', 'Сохранено');
    }

    public function imgDelete($id)
    {
        $img = AboutUsBlockImage::find($id);
        $img->delete();
        if ($img->image != null) {
            Storage::disk('static')->delete($img->image);
        }

        return true;
    }

    public function destroy($id)
    {
        AboutUsBlock::find($id)->delete();
        AboutUsBlockImage::where('about_us_block_id', $id)->delete();
        return redirect()->back()->with('success', 'Успешно удалено');
    }
}
