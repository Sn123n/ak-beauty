<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Categories;
use App\Models\User;
use App\Models\Slider;
use App\Models\Aboutus;
use App\Models\BasicInfo;
use App\Models\Product;
use App\Models\Banner;
use App\Models\ContactUs;
use App\Models\Location;
use App\Models\Coupon;
use App\Models\NailExtensions;
use App\Models\FooterIcon;

class HomeController extends Controller
{

    public function nailextenation()
    {
        $aboutUs = NailExtensions::first();
        return view('admin.component.nail_extention', compact('aboutUs'));
    }

    public function storenailextenation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'image2' => 'nullable|image|max:1024',
            'status' => 'required|in:0,1',
            'content' => 'required|string',
        ]);

        $aboutUs = NailExtensions::first();

        if ($aboutUs) {
            $imageName = $aboutUs->image;
            $iconName = $aboutUs->image2;

            if ($request->hasFile('image')) {
                if ($aboutUs->image && file_exists(public_path('nails/' . $aboutUs->image))) {
                    unlink(public_path('nails/' . $aboutUs->image));
                }
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('nails'), $imageName);
            }

            if ($request->hasFile('image2')) {
                if ($aboutUs->image2 && file_exists(public_path('nails/' . $aboutUs->image2))) {
                    unlink(public_path('nails/' . $aboutUs->image2));
                }
                $iconName = time() . '_icon.' . $request->image2->getClientOriginalExtension();
                $request->image2->move(public_path('nails'), $iconName);
            }

            $aboutUs->update([
                'title' => $request->title,
                'status' => $request->status,
                'content' => $request->content,
                'image' => $imageName,
                'image2' => $iconName,
            ]);
        } else {
            $imageName = null;
            $iconName = null;

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('nails'), $imageName);
            }

            if ($request->hasFile('image2')) {
                $iconName = time() . '_icon.' . $request->image2->getClientOriginalExtension();
                $request->image2->move(public_path('nails'), $iconName);
            }

            $aboutUs = NailExtensions::create([
                'title' => $request->title,
                'status' => $request->status,
                'content' => $request->content,
                'image' => $imageName,
                'image2' => $iconName,
            ]);
        }

        return redirect()->route('nailextenation')->with('success', 'Nail Extension updated successfully!');
    }
    public function aboutus()
    {
        $about = Aboutus::where('id', 2)->first();
        return view('admin.component.aboutus', compact('about'));
    }


    public function storeaboutus(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'imageicon' => 'nullable|image|max:1024',
            'status' => 'required|in:0,1',
            'content' => 'required|string',
        ]);

        $aboutUs = Aboutus::orderBy('id', 'desc')->first();
        $imageName = $aboutUs ? $aboutUs->image : null;
        $iconName = $aboutUs ? $aboutUs->imageicon : null;

        if ($request->hasFile('image')) {
            if ($aboutUs && $aboutUs->image && file_exists(public_path('aboutus/' . $aboutUs->image))) {
                unlink(public_path('aboutus/' . $aboutUs->image));
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('aboutus'), $imageName);
        }

        if ($request->hasFile('imageicon')) {
            if ($aboutUs && $aboutUs->imageicon && file_exists(public_path('aboutus/' . $aboutUs->imageicon))) {
                unlink(public_path('aboutus/' . $aboutUs->imageicon));
            }

            $iconName = time() . '_icon.' . $request->imageicon->getClientOriginalExtension();
            $request->imageicon->move(public_path('aboutus'), $iconName);
        }

        if ($aboutUs) {
            $aboutUs->update([
                'title' => $request->title,
                'status' => $request->status,
                'content' => $request->content,
                'image' => $imageName,
                'imageicon' => $iconName,
            ]);
        } else {
            Aboutus::create([
                'title' => $request->title,
                'status' => $request->status,
                'content' => $request->content,
                'image' => $imageName,
                'imageicon' => $iconName,
            ]);
        }

        return redirect()->route('aboutus')->with('success', 'About Us updated successfully!');
    }


    public function basicinfo()
    {
        $basicinfo = BasicInfo::first();
        return view('admin.component.basicinfo', compact('basicinfo'));
    }

    public function storeOrUpdatebasicinfo(Request $request)
    {
        $request->validate([
            'site_name' => 'required',
            'footer' => 'required',
            'image_dark' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'image_light' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        $header = BasicInfo::first();

        if ($header) {
            if ($request->hasFile('image_dark')) {
                if ($header->image_dark && file_exists(public_path('basicinfo/' . $header->image_dark))) {
                    unlink(public_path('basicinfo/' . $header->image_dark));
                }
                $imageNameDark = time() . '_dark.' . $request->image_dark->getClientOriginalExtension();
                $request->image_dark->move(public_path('/basicinfo'), $imageNameDark);
                $header->image_dark = $imageNameDark;
            } else {
                $imageNameDark = $header->image_dark;
            }

            if ($request->hasFile('image_light')) {
                if ($header->image_light && file_exists(public_path('basicinfo/' . $header->image_light))) {
                    unlink(public_path('basicinfo/' . $header->image_light));
                }
                $imageNameLight = time() . '_light.' . $request->image_light->getClientOriginalExtension();
                $request->image_light->move(public_path('/basicinfo'), $imageNameLight);
                $header->image_light = $imageNameLight;
            } else {
                $imageNameLight = $header->image_light;
            }

            $header->update([
                'site_name' => $request->site_name,
                'footer' => $request->footer,
                'font1' => $request->font1,
                'font2' => $request->font2,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'address' => $request->address,
                'address2' => $request->address2,
                'instagram' => $request->instagram,
                'facebook' => $request->facebook,
                'thread' => $request->thread,
                'twitter' => $request->twitter,
                'pinterest' => $request->pinterest,
                'image_dark' => $imageNameDark,
                'image_light' => $imageNameLight,
            ]);
        } else {

            $imageNameDark = null;
            $imageNameLight = null;

            if ($request->hasFile('image_dark')) {
                $imageNameDark = time() . '_dark.' . $request->image_dark->getClientOriginalExtension();
                $request->image_dark->move(public_path('/basicinfo'), $imageNameDark);
            }

            if ($request->hasFile('image_light')) {
                $imageNameLight = time() . '_light.' . $request->image_light->getClientOriginalExtension();
                $request->image_light->move(public_path('/basicinfo'), $imageNameLight);
            }

            BasicInfo::create([
                'site_name' => $request->site_name,
                'footer' => $request->footer,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'address' => $request->address,
                'address2' => $request->address2,
                'instagram' => $request->instagram,
                'facebook' => $request->facebook,
                'thread' => $request->thread,
                'twitter' => $request->twitter,
                'pinterest' => $request->pinterest,
                'image_dark' => $imageNameDark,
                'image_light' => $imageNameLight,
            ]);
        }

        return redirect()->back()->with('success', 'Basic Info updated successfully!');
    }

    public function contactus()
    {
        $contacts = ContactUs::orderBy('id', 'desc')->get();
        return view('admin.component.contactus', compact('contacts'));
    }

    public function contactusdestroy(ContactUs $contact)
    {
        $contact->delete();

        return redirect()->route('contactus')->with('success', 'Contactus deleted successfully.');
    }

    public function contactusdetail(Request $request)
    {
        $contact = ContactUs::where('id', $request->user_id)->first();

        if ($contact) {
            return response()->json([
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'message' => $contact->message
            ]);
        } else {
            return response()->json(['error' => 'Contact not found'], 404);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            switch ($request->page) {
                case 'categories':
                    $model = Categories::class;
                    break;
                case 'users':
                    $model = User::class;
                    break;
                case 'sliders':
                    $model = Slider::class;
                    break;
                case 'testimonial':
                    $model = Testimonial::class;
                    break;
                case 'products':
                    $model = Product::class;
                    break;
                case 'banners':
                    $model = Banner::class;
                    break;
                case 'contactus':
                    $model = ContactUs::class;
                    break;
                case 'users':
                    $model = User::class;
                    break;
                case 'countries':
                    $model = Location::class;
                    break;
                case 'coupons':
                    $model = Coupon::class;
                    break;
                case 'footer-icon':
                    $model = FooterIcon::class;
                    break;

                default:
                    return response()->json(['message' => 'Invalid page'], 400);
            }
            $modelInstance = $model::findOrFail($request->id);
            $modelInstance->status = $request->status;
            $modelInstance->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating status', 'error' => $e->getMessage()], 500);
        }
    }
}
