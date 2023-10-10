<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentsModel;

class StudentsController extends BaseController
{
    public function index()
    {
        $fetchStudent = new StudentsModel();
        $data['students'] = $fetchStudent->findAll();
        
        return view('students/list', $data);
    }

    public function createStudent()
    {
        $data['studentNumber'] = '20000_'.uniqid();
        
        return view('students/add', $data);
    }

    public function storeStudent()
    {
        $insertStudents = new StudentsModel();

        if($img = $this->request->getFile('studentProfile')){
            if($img->isValid() && ! $img->hasMoved()){
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        $data = array(
            'student_name' => $this->request->getPost('studentName'),
            'student_id' => $this->request->getPost('studentNum'),
            'student_section' => $this->request->getPost('studentSection'),
            'student_course' => $this->request->getPost('studentCourse'),
            'student_batch' => $this->request->getPost('studentBatch'),
            'student_grade_level' => $this->request->getPost('studentGradeLevel'),
            'student_profile' => $imageName,
        );

        $insertStudents->insert($data);

        return redirect()->to('/students')->with('success', 'Student Added Successfully!');
    }

    public function editStudent($id)
    {
        $fetchStudent = new StudentsModel();
        $data['student'] = $fetchStudent->where('id', $id)->first();

        return view('students/edit', $data);
    }

    public function updateStudent($id)
    {
        $updateStudent = new StudentsModel();
        $db = db_connect();

        if($img = $this->request->getFile('studentProfile')){
            if($img->isValid() && ! $img->hasMoved()){
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        if(!empty($_FILES['studentProfile']['name'])){
            $db->query("UPDATE tbl_students SET student_profile = '$imageName' WHERE id = '$id' ");
        }

        $data = array(
            'student_name' => $this->request->getPost('studentName'),
            'student_id' => $this->request->getPost('studentNum'),
            'student_section' => $this->request->getPost('studentSection'),
            'student_course' => $this->request->getPost('studentCourse'),
            'student_batch' => $this->request->getPost('studentBatch'),
            'student_grade_level' => $this->request->getPost('studentGradeLevel')
        );

        $updateStudent->update($id, $data);

        return redirect()->to('/students')->with('success', 'Student Updated Successfully');
    }

    public function deleteStudent($id)
    {
        $updateStudent = new StudentsModel();
        $updateStudent->delete($id);

        return redirect()->to('/students')->with('success', 'Student Deleted Successfully');
    }
}
