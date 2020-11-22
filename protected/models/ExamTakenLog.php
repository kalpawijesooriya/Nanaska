<?php

/**
 * This is the model class for table "exam_taken_log".
 *
 * The followings are the available columns in table 'exam_taken_log':
 * @property integer $id
 * @property integer $exam_id
 * @property integer $user_id
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Exam $exam
 */
class ExamTakenLog extends CActiveRecord {

    public $user_name;
    public $exam_name;
    public $exam_type;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam_taken_log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('exam_id', 'required'),
            array('exam_id, user_id', 'numerical', 'integerOnly' => true),
            array('timestamp', 'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false, 'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, exam_name, user_name, exam_type, timestamp', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'exam_id' => 'Exam',
            'user_id' => 'User',
            'timestamp' => 'Timestamp',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('user', 'exam');

        $criteria->compare('t.id', $this->id);
        $criteria->compare('exam.exam_name', $this->exam_name, true);
        $criteria->compare('exam.exam_type', $this->exam_type, true);
        $criteria->compare('user.email', $this->user_name, true);
        $criteria->compare('t.timestamp', $this->timestamp, true);
        $criteria->addCondition("t.timestamp > DATE_SUB(now(), INTERVAL 1 HOUR)");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'exam_name' => array(
                        'asc' => 'exam.exam_name',
                        'desc' => 'exam.exam_name DESC',
                    ),
                    'exam_type' => array(
                        'asc' => 'exam.exam_type',
                        'desc' => 'exam.exam_type DESC',
                    ),
                    'user_name' => array(
                        'asc' => 'user.email',
                        'desc' => 'user.email DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ExamTakenLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
