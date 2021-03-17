<?php

namespace App\Http\Controllers\admin;

use App\Models\BodyPartExercise;
use Validator, Redirect, Response, File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Exercise;
use App\Models\Goal;
use App\Models\TargetMuscle;
use App\Models\BodyPart;
use App\Models\Equipment;
use App\Models\TrainingForm;
use App\Models\Discipline;
Use App\Models\Level;
Use App\Models\Priority;
use Intervention\Image\Facades\Image as Image;
use App\Traits\ZestLogTrait;
use Illuminate\Support\Facades\Storage;
use DB;

class DatabaseController extends Controller
{
    use ZestLogTrait;

    /**
     * This is used to show index page of exercises
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->isEmptyAll = true;
        $this->getExerciseFilters();
        return view('admin.database.index',$this->data);
//        return view('admin.database.index', compact('bodyParts', 'targetMuscle', 'equipment', 'trainingForm', 'dicipline', 'level', 'priority'));
    }

    /**
     * This is used to save exercise data
     *
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        ini_set('max_execution_time', '0');
//        request()->validate([
//            'fileUploadImageMale' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'fileUploadGifMale' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'fileUploadImageFemale' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'fileUploadGifFemale' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
        $obj = Exercise::find($request->id);
        if ($obj) {

            //todo need to add backend validation for images and other fields
            $this->data = $request->all();
            if (!empty($this->data['fileUploadVideoMale'])) {
                $fileName = $this->uploadVedio($this->data['fileUploadVideoMale'], exerciseVideoPathMale);
                $result = move_uploaded_file($_FILES["fileUploadVideoMale"]["tmp_name"],
                    'exercise/male/videos/' . $fileName);
                $obj->male_video = $fileName;
            }
            if (!empty($this->data['fileUploadVideoFemale'])) {
                $fileName = $this->uploadVedio($this->data['fileUploadVideoFemale'], exerciseVideoPathFemale);
                $result = move_uploaded_file($_FILES["fileUploadVideoFemale"]["tmp_name"],
                    'exercise/female/videos/' . $fileName);
                $obj->female_video = $fileName;
            }
            if (!empty($this->data['fileUploadImageMale'])) {
                $fileName = $this->uploadImage($this->data['fileUploadImageMale'], exerciseImagePathMale);
                $obj->male_illustration = $fileName;

            }
            if (!empty($this->data['fileUploadGifMale'])) {
                $fileName = $this->uploadImage($this->data['fileUploadGifMale'], exerciseGifPathMale);
                $obj->male_gif = $fileName;
            }
            if (!empty($this->data['fileUploadImageFemale'])) {
                $fileName = $this->uploadImage($this->data['fileUploadImageFemale'], exerciseImagePathFemale);
                $obj->female_illustration = $fileName;
            }
            if (!empty($this->data['fileUploadGifFemale'])) {
                $fileName = $this->uploadImage($this->data['fileUploadGifFemale'], exerciseGifPathFemale);
                $obj->female_gif = $fileName;
            }
            $obj->name = $request->input('title');
            $obj->body_part_id = $request->input('body_part');
            $obj->target_muscle_id = $request->input('target_Muscle');
            $obj->equipment_id = $request->input('equipment');
            $obj->training_form_id =$request->input('training_form');
            $obj->discipline_id = $request->input('dicipline');
            $obj->level_id = $request->input('level');
            $obj->priority_id = $request->input('priority');
            $obj->description = $request->input('description');
            $obj->save();
        }

        return Redirect::to("database")->withSuccess('Great! Data has been Update successfully.');
    }

    /**
     * This is used to get exercises data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getExercises(Request $request)
    {
        $this->params['perPage'] = 5;
        $this->params['page'] = $request->input('page');
        $this->params['search'] = $request->input('search');
        $this->params['body_part'] = $request->input('body_part');
        $this->params['target_muscle'] = $request->input('target_muscle');
        $this->params['equipment'] = $request->input('equipment');
        $this->params['training_form'] = $request->input('training_form');
        $this->params['dicipline'] = $request->input('dicipline');
        $this->params['level'] = $request->input('level');
        $this->params['priority'] = $request->input('priority');
        $data = Exercise::getExercises($this->params);
        $this->isEmptyAll = true;
        $this->getFilters();
        $view = view('admin.database._page-data', ['data' => $data],$this->data)->render();

        return response()->json(['data' => $view]);
    }

    /**
     * This is used to import excel file into database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        ini_set('max_execution_time', '0');

        $rows = Excel::toArray(new Exercise(), $request->file('file'));
        $arr = [];
        foreach ($rows[0] as $key => $item) {
            if ($key) {
                $targetMuscleId = $bodyPartId = $equipmentId = $trainingForm = 0;
                $disciplineId = $levelId = $priorityId = "NA";
                $index = $key - 1;
//                $splitId = explode('-', $item[0]);
                $splitId = substr($item[0],0,4);
                $arr[$index]['exercise_id'] = $splitId;
                $arr[$index]['second_part_id'] = $item[0];
                $arr[$index]['name'] = $item[1];
                $obj = BodyPartExercise::where('name', '=', $item[2])->first();
                if ($obj) {
                    $bodyPartId = $obj->id;
                }
                $arr[$index]['body_part_id'] = $bodyPartId;
                $obj = TargetMuscle::where('name', '=', $item[3])->first();
                if ($obj) {
                    $targetMuscleId = $obj->id;
                }
                $arr[$index]['target_muscle_id'] = $targetMuscleId;
                $obj = Equipment::where('name', '=', $item[4])->first();
                if ($obj) {
                    $equipmentId = $obj->id;
                }
                $arr[$index]['equipment_id'] = $equipmentId;

                $obj = TrainingForm::where('name', '=', $item[5])->first();
                if ($obj) {
                    $trainingForm = $obj->id;
                }
                $arr[$index]['training_form_id'] = $trainingForm;
                //discipline
                $obj = Discipline::where('name', '=', $item[6])->first();
                if ($obj) {
                    $disciplineId = $obj->id;
                }
                $arr[$index]['discipline_id'] = $disciplineId;
                //level
                $obj = Level::where('name', '=', $item[7])->first();
                if ($obj) {
                    $levelId = $obj->id;
                }
                $arr[$index]['level_id'] = $levelId;
                //priority
                $obj = Priority::where('name', '=', $item[8])->first();
                if ($obj) {
                    $priorityId = $obj->id;
                }
                $arr[$index]['priority_id'] = $priorityId;
                $arr[$index]['description'] = $item[9];
                $arr[$index]['created_at'] = currentDateTime();
                $arr[$index]['updated_at'] = currentDateTime();
            }
        }
        Exercise::insert($arr);

        return redirect()->back()->with('success', 'Data has been Imported Successfully');
    }


    /**
     * Remove the specified Exercise from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $splitId = explode('_', $id)[1];
        $obj = Exercise::find($splitId);
        $this->message = 'There is problem to delete Exercise';
        if ($obj && $obj->delete()) {
            $this->message = 'Exercise is deleted successfully';
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $splitId]);
    }
    /*
     * Import Exercise Images Gif Videos
     */
    public function importImages(Request $request, $type = '')
    {
        ini_set('max_execution_time', '0');
        if ($type == '' || $type == 'male_illustration') {
            $path = 'exercise/male/images';
            $dbColumn = 'male_illustration';
        } elseif ($type == 'male_gif') {
            $path = 'exercise/male/gif';
            $dbColumn = 'male_gif';
        } elseif ($type == 'male_video') {
            $path = 'exercise/male/videos';
            $dbColumn = 'male_video';
        } elseif ($type == 'female_illustration') {
            $path = 'exercise/female/images';
            $dbColumn = 'female_illustration';
        } elseif ($type == 'female_gif') {
            $path = 'exercise/female/gif';
            $dbColumn = 'female_gif';
        } elseif ($type == 'female_video') {
            $path = 'exercise/female/videos';
            $dbColumn = 'female_video';
        }
        $val = 0;
        $files = File::allFiles(public_path($path));
        foreach ($files as $row) {
            $splitId = substr($row->getBasename(), 0, 4);
//            $splitId = explode('-', $row->getBasename());
            $obj = Exercise::where('exercise_id', '=', $splitId)->first();
            if (!empty($obj)) {
                $obj->$dbColumn = $row->getBasename();
                $obj->save();
                $val++;
            }
        }
        return $val . " " . $type . " Updated Successfully";
    }
}
