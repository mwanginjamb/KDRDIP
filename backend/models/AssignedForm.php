<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Assigned form
 */
class AssignedForm extends Model
{
	public $comments;
	public $assignedTo;
	public $complaintStatusId;
	public $activityId;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['comments'], 'string'],
			[['assignedTo', 'complaintStatusId', 'activityId'], 'number'],
			[['comments'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'comments' => 'Comments',
			'assignedTo' => 'Assign To',
			'complaintStatusId' => 'Enquiries Status',
			'activityId' => 'Activity',
		];
	}
}
