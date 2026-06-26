<?php
/**
 * Home Controller
 * Handles general pages like home, dashboard, about, contact
 */

class HomeController extends Controller {
    /**
     * Show homepage
     */
    public function index() {
        $this->view('pages/home');
    }

    /**
     * Show dashboard (requires login)
     */
    public function dashboard() {
        // Check if user is logged in
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }

        // Get statistics for dashboard
        $stats = [];

        // Count departments
        $deptModel = $this->model('Department');
        $stats['departments_count'] = $deptModel->count();

        // Count teachers
        $teacherModel = $this->model('Teacher');
        $stats['teachers_count'] = $teacherModel->count();

        // Count facilities
        $facilityModel = $this->model('Facility');
        $stats['facilities_count'] = $facilityModel->count();

        // Count users
        $userModel = $this->model('User');
        $stats['users_count'] = $userModel->count();

        $this->view('pages/dashboard', $stats);
    }

    /**
     * Show about page
     */
    public function about() {
        $this->view('pages/about');
    }

    /**
     * Show contact page
     */
    public function contact() {
        $this->view('pages/contact');
    }

    /**
     * Show privacy policy page
     */
    public function privacy() {
        $this->view('pages/privacy');
    }

    /**
     * Show terms of service page
     */
    public function terms() {
        $this->view('pages/terms');
    }
}
?>