<?php

namespace App\Http\controllers\Website;

use App\Http\controllers\Controller;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // --- === Home View Function === --- \\
    public function Home()
    {
        $schools = DB::table('p_schools')->orderBy('school_id', 'DESC')->take(8)->get();
        $blogs = DB::table('p_schools__blogs')->get();
        return view('Web.Home.Home', ['schools' => $schools, 'blogs' => $blogs]);
    }
    // --- === Home View Function === --- \\

    // --- === School Deatile Function === --- \\
    public function SchoolDetail($school_slug)
    {
        $schools = DB::table('p_schools')->where('p_schools.school_slug', $school_slug)->get();
        $row = '';
        foreach ($schools as $data) {
            $row = $data;
            $row->brochure = DB::table('p_schools__brochures')->where('school_id', $row->school_id)->get();
            $row->courses = DB::table('p_schools__courses')->where('school_id', $row->school_id)->get();
            $row->facility = DB::table('p_schools__facilities')->where('school_id', $row->school_id)->get();
            $row->gallery = DB::table('p_schools__gallery')->where('school_id', $row->school_id)->get();
            $row->eligibility = DB::table('p_schools__eligibilities')->where('school_id', $row->school_id)->get();
            $row->infrastructure = DB::table('p_schools__infrastructure')->where('school_id', $row->school_id)->get();
        }
        return view('Web.Home.SchoolDetail', ['schools' => $row]);
    }
    // --- === School Deatile Function === --- \\

    // --- === All School List Function === --- \\
    public function SchoolSearch(Request $req)
    {

        $school_medium = $req->input('school-medium');
        $school_type = $req->input('school-type');
        $keyword = $req->input('school_search_key');

        $schools = DB::table('p_schools')
            ->where(function ($query) use ($school_medium, $school_type, $keyword) {
                if (!empty($school_medium)) {
                    $query->orWhereIn('school_medium', $school_medium);
                }
                if (!empty($school_type)) {
                    $query->orWhereIn('syllabus_type', $school_type);
                }
                if ($keyword != '' && $keyword != null) {
                    $query->whereRaw("MATCH(school_name,syllabus_type,school_city,school_address,school_location ) AGAINST ('$keyword')");
                }
            })
            ->paginate(6);
        // --- Last Page --- \\
        $last_page = $schools->lastPage();
        // --- Last Page --- \\

        // --- === Ajax Call For Second page === --- \\
        if ($req->ajax()) {
            $cardView = view('Components.PaginationCard', ['schools' => $schools])->render();
            return response()->json(['data' => $cardView]);
        }
        // --- === Ajax Call For Second page === --- \\

        if (count($schools) > 0) {
            return view('Web.Home.AllSchoolList', ['schools' => $schools, 'lastpage' => $last_page]);
        } else {
            return view('Web.Home.404');
        }

    }
    // --- === All School List Function === --- \\

    // --- === All School List Function === --- \\
    public function AllSchoolList(Request $req)
    {
        $schools = DB::table('p_schools')->orderBy('school_id', 'DESC')->paginate(6);
        // --- Last Page --- \\
        $last_page = $schools->lastPage();
        // --- Last Page --- \\

        // --- === Ajax Call For Second page === --- \\
        if ($req->ajax()) {
            $cardView = view('Components.PaginationCard', ['schools' => $schools])->render();
            return response()->json(['data' => $cardView]);
        }
        // --- === Ajax Call For Second page === --- \\

        return view('Web.Home.AllSchoolList', ['schools' => $schools, 'lastpage' => $last_page]);
    }
    // --- === All School List Function === --- \\

    // --- === All School Blog View Function === --- \\
    public function AllBlogs(Request $req)
    {
        $blogs = DB::table('p_schools__blogs')->orderBy('blog_id', 'DESC')->paginate(6);
        // --- Last Page --- \\
        $last_page = $blogs->lastPage();
        // --- Last Page --- \\

        // --- === Ajax Call For Second page === --- \\
        if ($req->ajax()) {
            $cardView = view('Components.PaginationBlogCard', ['blogs' => $blogs])->render();
            return response()->json(['data' => $cardView]);
        }
        // --- === Ajax Call For Second page === --- \\

        return view('Web.Home.AllBlogs', ['blogs' => $blogs, 'lastpage' => $last_page]);
    }
    // --- === All School Blog View Function === --- \\

    // ---- === Blog Detail Function === --- \\
    public function BlogDetail($blog_id)
    {
        $blogs = DB::table('p_schools__blogs')
            ->select('p_schools__blogs.*', 'p_schools.school_name', 'p_schools.school_logo')
            ->leftjoin('p_schools', 'p_schools.school_id', 'p_schools__blogs.school_id')
            ->where('blog_id', $blog_id)->get();

        return view('Web.Home.BlogDetail', ['blogs' => $blogs]);
    }
    // ---- === Blog Detail Function === --- \\
}