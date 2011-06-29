<?php

/**
 * A base controller class that helps display the firm dropdown and the patient name.
 * It is extended by all non-admin controllers.
 */

class BaseController extends Controller
{
	public $selectedFirmId;
	public $firms;
	public $showForm = false;
	public $patientId;
	public $patientName;

	protected function beforeAction($action)
	{
		$app = Yii::app();

		if (isset($app->session['firms']) && count($app->session['firms'])) {
			$this->showForm = true;

			$this->firms = $app->session['firms'];
			$this->selectedFirmId = $app->session['selected_firm_id'];
		}

		if (isset($app->session['patient_name'])) {
			$this->patientName = $app->session['patient_name'];
		}

		return parent::beforeAction($action);
	}

	public function checkPatientId()
	{
		$app = Yii::app();

		if (isset($app->session['patient_id'])) {
			$this->patientId = $app->session['patient_id'];
			$this->patientName = $app->session['patient_name'];
		} else {
			throw new CHttpException(403, 'You are not authorised to perform this action.');
		}
	}

	public function storeData()
	{
		$app = Yii::app();

		if (!empty($app->session['firms'])) {
			$this->showForm = true;

			$this->firms = $app->session['firms'];
			$this->selectedFirmId = $app->session['selected_firm_id'];
		}

		if (isset($app->session['patient_name'])) {
			$this->patientName = $app->session['patient_name'];
		}
	}

	public function logActivity($message)
	{
		$addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';

		Yii::log($message . ' from ' . $addr, "user", "userActivity");
	}
}
