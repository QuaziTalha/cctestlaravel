<?php

namespace App\Http\controllers\Admin\Merchandise;

use App\Http\controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{

// --- === Merchandise View Function === --- \\
public function Merchandiser()
{
    return view('Admin.Merchandise.Merchandiser');
}
// --- === Merchandise View Function === --- \\

// --- === Merchandise View Function === --- \\
    public function Merchandise()
    {
        return view('Admin.Merchandise.Merchandise');
    }
// --- === Merchandise View Function === --- \\

// --- === Merchandise List Function === --- \\
    public function GetMerchandiseList()
    {
        $data = DB::table('p_schools__merchandise')
            ->get();
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '
                <row style="display: inline-flex;">
                <button type="button" id="edit-btn" title="Edit" class="btn btn-icon rounded-pill btn-success approval-btn" onclick="InsertModal(this)" data-id="'.$data->merchandise_id.'" data-name="'.$data->merchandise_name.'" data-desc="'.$data->merchandise_desc.'"><i class="fa-solid fa-pencil"></i></button>

                <button type="button" title="View Detail" id="view-btn" onclick="Details(this)" class="btn btn-icon rounded-pill btn-primary approval-btn" data-title="'. $data->merchandise_name .'"  data-desc="'.$data->merchandise_desc.'" data-image="'.$data->merchandise_img.'"><i class="fa-solid fa-eye"></i></button>

                <button type="button" id="delete-btn" title="Delete" class="btn btn-icon rounded-pill btn-danger approval-btn" onclick="DeleteMerchandise(this)" data-id="'.$data->merchandise_id.'"><i class="fa-solid fa-trash"></i></button></row>';
            })
            ->make(true);
    }
// --- === Merchandise List Function === --- \\

// --- ===Merchandise Store and Update Function === --- \\
    public function MerchandiseStore(Request $req)
    {
        /* Defining Values */
        $merchandise_id = $req->input('merchandise_id');
        $merchandise_name = $req->input('merchandise_name');
        $merchandise_desc = $req->input('merchandise_desc');
        $image = $req->input('merchandise_img');
        /* Defining Values */


        /* Inserting New Entry If merchandise_id is not Provided */
        if ($merchandise_id == null && $merchandise_id == "") {

            /* Decoding Base64 and setting Image name */
            $image_parts = explode(";base64,", $image);
            $image = base64_decode($image_parts[1]);
            $image_name = 'merchandise_image_' . rand(1, 91898) . '.png';
            /* Decoding Base64 and setting Image name */

            /* Error Handling for Image */
            if ($image !== "" || $image !== null) {
                file_put_contents(public_path('portal_images/merchandise_images/' . $image_name), $image);
            } else {
                return response()->json(['success' => false, 'message' => 'An Error Occurred while moving Image.']);
            }
            /* Error Handling for Image */

            /* Insert Query and Response */
            $insert = DB::table('p_schools__merchandise')->insert([
                'merchandise_name' => $merchandise_name,
                'merchandise_desc' => $merchandise_desc,
                'merchandise_img' => $image_name,
            ]);
            if ($insert == 1) {
                return response()->json(['success' => true, 'message' => "Merchandise created successfully"]);
            } else {
                return response()->json(['success' => false, 'message' => "Oops somethinge went wrong"]);
            }
            /* Insert Query and Response */
        }
        /* Inserting New Entry If merchandise_id is not Provided */

        /* Else Updating Entry with Provided merchandise_id */
        else {
            /* Fetching Data From Existing Entry */
            $data = DB::table('p_schools__merchandise')->where('merchandise_id', $merchandise_id)->first();
            /* Fetching Data From Existing Entry */

            /* Deleting Existing Image and putting new Image If Provided */
            if ($req->input('merchandise_img') != "" || $req->input('merchandise_img') != null) {

                /* Decoding Base64 and setting Image name */
                $image_parts = explode(";base64,", $image);
                $image = base64_decode($image_parts[1]);
                $image_name = 'merchandise_image_' . rand(1, 91898) . '.png';
                /* Decoding Base64 and setting Image name */

                file_put_contents(public_path('portal_images/merchandise_images/' . $image_name), $image);
                if ($data->merchandise_img != "" && $data->merchandise_img != null) {
                    /* Deleting Previous Image */
                    if (file_exists("public/portal_images/merchandise_images/" . $data->merchandise_img)) {
                        unlink("public/portal_images/merchandise_images/" . $data->merchandise_img);
                    } else {
                        error_log($data->merchandise_img . " file does not exist");//If Previous Image is Somehow Deleted Only make an error log.
                    }
                    /* Deleting Previous Image */
                }
            }
            /* Deleting Existing Image and putting new Image If Provided */

            /* Else just Set image_name to the previous value in DB */
            else {
                $image_name = $data->merchandise_img;
            }
            /* Else just Set image_name to the previous value in DB */

            /* Update Query and Reponse */
            $data = DB::table('p_schools__merchandise')
            ->where('merchandise_id', "=" ,$merchandise_id)
                ->update([
                    'merchandise_name' => $merchandise_name,
                    'merchandise_desc' => $merchandise_desc,
                    'merchandise_img' => $image_name,
                ]);
            if ($data == 1) {
                return response()->json(['success' => true, 'message' => "Merchandise updated successfully"]);
            } else {
                return response()->json(['success' => false, 'message' => "Oops somethinge went wronge", 'error' => $data]);
            }
            /* Update Query and Reponse */
        }
        /* Else Updating Entry with Provided merchandise_id */
    }
// --- ===Merchandise Store and Update Function === --- \\

// --- ===Merchandise Delete Function === --- \\
    public function MerchandiseDelete(Request $req)
    {
        $data = DB::table('p_schools__merchandise')->where('merchandise_id', $req->input('merchandise_id'))->first();
        if ($data->merchandise_img != "" && $data->merchandise_img != null) {
            if (file_exists('public/portal_images/merchandise_images/' . $data->merchandise_img)) {
                unlink('public/portal_images/merchandise_images/' . $data->merchandise_img);
            }
        }
        $delete = DB::table('p_schools__merchandise')->where('merchandise_id', $req->input('merchandise_id'))->delete();
        if ($delete == 1) {
            return response()->json(['success' => true, 'message' => "Merchandise deleted successfully"]);
        } else {
            return response()->json(['success' => false, 'message' => "Oops somethinge went wronge"]);
        }
    }
// --- ===Merchandise Delete Function === --- \\



// --- === Merchandiser List Function === --- \\
public function GetMerchandiserList()
{
    $data = DB::table('p_schools__merchandiser')
        ->get();
    return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return '
            <row style="display: inline-flex;">
            <button type="button" id="edit-btn" title="Edit" class="btn btn-icon rounded-pill btn-success approval-btn" onclick="InsertModal(this)" data-id="'.$data->merchandiser_id.'" data-name="'.$data->merchandiser_name.'" data-desc="'.$data->merchandiser_desc.'"><i class="fa-solid fa-pencil"></i></button>

            <button type="button" title="View Detail" id="view-btn" onclick="Details(this)" class="btn btn-icon rounded-pill btn-primary approval-btn" data-title="'. $data->merchandiser_name .'"  data-desc="'.$data->merchandiser_desc.'" data-image="'.$data->merchandiser_img.'"><i class="fa-solid fa-eye"></i></button>

            <button type="button" id="delete-btn" title="Delete" class="btn btn-icon rounded-pill btn-danger approval-btn" onclick="DeleteMerchandiser(this)" data-id="'.$data->merchandiser_id.'"><i class="fa-solid fa-trash"></i></button></row>';
        })
        ->make(true);
}
// --- === Merchandiser List Function === --- \\

// --- ===Merchandiser Store and Update Function === --- \\
public function MerchandiserStore(Request $req)
{
    /* Defining Values */
    $merchandiser_id = $req->input('merchandiser_id');
    $merchandiser_name = $req->input('merchandiser_name');
    $merchandiser_desc = $req->input('merchandiser_desc');
    $image = $req->input('merchandiser_img');
    /* Defining Values */


    /* Inserting New Entry If merchandiser_id is not Provided */
    if ($merchandiser_id == null && $merchandiser_id == "") {

        /* Decoding Base64 and setting Image name */
        $image_parts = explode(";base64,", $image);
        $image = base64_decode($image_parts[1]);
        $image_name = 'merchandiser_image_' . rand(1, 91898) . '.png';
        /* Decoding Base64 and setting Image name */

        /* Error Handling for Image */
        if ($image !== "" || $image !== null) {
            file_put_contents(public_path('portal_images/merchandiser_images/' . $image_name), $image);
        } else {
            return response()->json(['success' => false, 'message' => 'An Error Occurred while moving Image.']);
        }
        /* Error Handling for Image */

        /* Insert Query and Response */
        $insert = DB::table('p_schools__merchandiser')->insert([
            'merchandiser_name' => $merchandiser_name,
            'merchandiser_desc' => $merchandiser_desc,
            'merchandiser_img' => $image_name,
        ]);
        if ($insert == 1) {
            return response()->json(['success' => true, 'message' => "Merchandiser created successfully"]);
        } else {
            return response()->json(['success' => false, 'message' => "Oops somethinge went wrong"]);
        }
        /* Insert Query and Response */
    }
    /* Inserting New Entry If merchandiser_id is not Provided */

    /* Else Updating Entry with Provided merchandiser_id */
    else {
        /* Fetching Data From Existing Entry */
        $data = DB::table('p_schools__merchandiser')->where('merchandiser_id', $merchandiser_id)->first();
        /* Fetching Data From Existing Entry */

        /* Deleting Existing Image and putting new Image If Provided */
        if ($req->input('merchandiser_img') != "" || $req->input('merchandiser_img') != null) {

            /* Decoding Base64 and setting Image name */
            $image_parts = explode(";base64,", $image);
            $image = base64_decode($image_parts[1]);
            $image_name = 'merchandiser_image_' . rand(1, 91898) . '.png';
            /* Decoding Base64 and setting Image name */

            file_put_contents(public_path('portal_images/merchandiser_images/' . $image_name), $image);
            if ($data->merchandiser_img != "" && $data->merchandiser_img != null) {
                /* Deleting Previous Image */
                if (file_exists("public/portal_images/merchandiser_images/" . $data->merchandiser_img)) {
                    unlink("public/portal_images/merchandiser_images/" . $data->merchandiser_img);
                } else {
                    error_log($data->merchandiser_img . " file does not exist");//If Previous Image is Somehow Deleted Only make an error log.
                }
                /* Deleting Previous Image */
            }
        }
        /* Deleting Existing Image and putting new Image If Provided */

        /* Else just Set image_name to the previous value in DB */
        else {
            $image_name = $data->merchandiser_img;
        }
        /* Else just Set image_name to the previous value in DB */

        /* Update Query and Reponse */
        $data = DB::table('p_schools__merchandiser')
        ->where('merchandiser_id', "=" ,$merchandiser_id)
            ->update([
                'merchandiser_name' => $merchandiser_name,
                'merchandiser_desc' => $merchandiser_desc,
                'merchandiser_img' => $image_name,
            ]);
        if ($data == 1) {
            return response()->json(['success' => true, 'message' => "Merchandiser updated successfully"]);
        } else {
            return response()->json(['success' => false, 'message' => "Oops somethinge went wronge", 'error' => $data]);
        }
        /* Update Query and Reponse */
    }
    /* Else Updating Entry with Provided merchandiser_id */
}
// --- ===Merchandiser Store and Update Function === --- \\

// --- ===Merchandiser Delete Function === --- \\
public function MerchandiserDelete(Request $req)
{
    $data = DB::table('p_schools__merchandiser')->where('merchandiser_id', $req->input('merchandiser_id'))->first();
    if ($data->merchandiser_img != "" && $data->merchandiser_img != null) {
        if (file_exists('public/portal_images/merchandiser_images/' . $data->merchandiser_img)) {
            unlink('public/portal_images/merchandiser_images/' . $data->merchandiser_img);
        }
    }
    $delete = DB::table('p_schools__merchandiser')->where('merchandiser_id', $req->input('merchandiser_id'))->delete();
    if ($delete == 1) {
        return response()->json(['success' => true, 'message' => "Merchandiser deleted successfully"]);
    } else {
        return response()->json(['success' => false, 'message' => "Oops somethinge went wronge"]);
    }
}
// --- ===Merchandiser Delete Function === --- \\
}
