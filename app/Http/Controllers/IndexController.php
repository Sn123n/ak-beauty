<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aboutus;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Categories;
use App\Models\BasicInfo;
use App\Models\ContactUs;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use App\Mail\UserInquiryMail;
use App\Mail\AdminInquiryMail;
use Illuminate\Support\Facades\Mail;
use App\Models\GetInspired;
use App\Models\DiscountText;
use Illuminate\Support\Facades\View;
use App\Models\Seo;
use App\Models\FrenchManicure;
use App\Models\TermCondition;
use App\Models\PrivacyPolicy;
use App\Models\NailExtensions;
use App\Models\FooterIcon;


class IndexController extends Controller
{

    public function index()
    {
        $aboutUs = Aboutus::first();
        $sliders = Slider::where('status', 1)->get();
        $categories = Categories::where('status', 1)->get();
        $homeCategories = Categories::where('status', 1)->get();
        $deals  = GetInspired::where('status', 1)->get();
        $nails = NailExtensions::where('status', 1)->first();
        $products = Product::where('status', 1)->latest()->get();
        $testimonials = Testimonial::where('status', 1)->latest()->get();
        $frenchManicure = FrenchManicure::where('status', 1)->first();
        $footers = FooterIcon::where('status', 1)->get();

        // Get DIY Nail Art category products
        $diyNailArtCategory = Categories::where('name', 'DIY Nail Art')->where('status', 1)->first();
        $diyNailArtProducts = [];
        if ($diyNailArtCategory) {
            $diyNailArtProducts = Product::where('category_id', $diyNailArtCategory->id)
                ->where('status', 1)
                ->latest()
                ->limit(8)
                ->get();
        }

        $seoData = getSeo('user_home');
        extract($seoData);

        return view('front.layouts.index', compact(
            'aboutUs',
            'sliders',
            'categories',
            'homeCategories',
            'testimonials',
            'products',
            'deals',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'frenchManicure',
            'nails',
            'footers',
            'diyNailArtProducts',
            'diyNailArtCategory'
        ));
    }

    public function aboutus()
    {
        $about = Aboutus::where('id', 2)->first();
        $testimonials = Testimonial::where('status', 1)->latest()->get();
        $seoData = getSeo('user_aboutus');
        extract($seoData);
        return view('front.component.about', compact(
            'about',
            'testimonials',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }

    public function contactus()
    {
        $data = BasicInfo::first();
        $seoData = getSeo('user_contactus');

        return view('front.component.contact', array_merge([
            'data' => $data,
        ], $seoData));
    }

    public function storecontactus(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|digits:10',
            'message' => 'required',
        ]);

        $contact = ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => 1,
        ]);


        //  Mail::to($request->email)->send(new UserInquiryMail($request->name));

        // $adminEmail = 'arya.developers.2017@gmail.com';
        // Mail::to($adminEmail)->send(new AdminInquiryMail($contact));

        $userEmailContent = View::make('front.emails.user_inquiry', ['name' => $request->name])->render();
        $adminEmailContent = View::make('front.emails.admin_inquiry', ['contact' => $contact])->render();

        sendRegistrationEmail($request->email, 'Thank you for contacting us', $userEmailContent);
        sendRegistrationEmail('support@rizester.com', 'New Contact Us Inquiry', $adminEmailContent);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Contact Inquiry Sent successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Contactus Inquiry Sent successfully!');
    }

    public function terms()
    {
        $terms = TermCondition::first();
        $seoData = getSeo('terms_condition');
        extract($seoData);
        return view('front.component.terms-of-service', compact(
            'terms',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }
    public function privacypolicy()
    {
        $privacypolicy = PrivacyPolicy::first();
        $seoData = getSeo('privacy_policy');
        extract($seoData);
        return view('front.component.privacy-policy', compact(
            'privacypolicy',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }
    public function shipping_policy()
    {
        $shippingpolicy = PrivacyPolicy::find(2);
        return view('front.component.shipping-policy', compact('shippingpolicy'));
    }
    public function refund_policy()
    {
        $refundPolicy = PrivacyPolicy::find(3);
        return view('front.component.refund-policy', compact('refundPolicy'));
    }
    public function nail_extention()
    {
        $nails = NailExtensions::where('status', 1)->first();
        $seoData = getSeo('nail_extensions');
        extract($seoData);
        
        return view('front.component.nail_extention', compact(
            'nails',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }
    
    public function blogdetail($id)
    {
        // For now, return a simple blog detail view
        // You can expand this later with proper blog functionality
        $seoData = getSeo('blog_detail');
        extract($seoData);
        
        return view('front.component.blog_detail', compact(
            'id',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ));
    }
}
