<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $news_id
 * @property string $subject
 * @property string $message
 * @property string $send_date_time
 * @property string $attachment
 * @property integer $level_id
 * @property string $news_type
 * @property integer $course_id
 *
 * The followings are the available model relations:
 * @property Level $level
 * @property Course $course
 */
class News extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return News the static model class
     */
    public $attachment;
    public $course_id;
    public $level_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('message', 'required'),
            array('subject','required'),
            array('course_id', 'safe'),
            array('level_id, course_id', 'required', 'on' => 'level'),
            // array('subject, message,','required'),
            array('level_id', 'numerical', 'integerOnly' => true),
            array('subject', 'length', 'max' => 255),
            array('message', 'length', 'max' => 160),
            array('send_date_time', 'length', 'max' => 50),
            array('news_type', 'length', 'max' => 512),
            //most common file types
            array('attachment', 'file', 'types' => 'jpg, gif, png, bmp, psd, tif, tiff, yuv, pct, pdf, doc, docx, txt, vsd , ppt, pptx, msg, xml, 7z, rar, zip, ', 'allowEmpty' => true, 'on' => 'update'),
            //array('attachment', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('news_id, subject, message, send_date_time, attachment, level_id, news_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
                //'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'news_id' => 'News ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'send_date_time' => 'Send Date Time',
            'attachment' => 'Attachment',
            'level_id' => 'Level',
            'news_type' => 'News Type',
            'course_id' => 'Course',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;


        $criteria->with = array('level','level.course');
        
        $criteria->compare('news_id', $this->news_id);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('message', $this->message, true);
        //$criteria->compare('send_date_time',$this->send_date_time,true);
        $criteria->compare('attachment', $this->attachment, true);
        $criteria->compare('level.level_name', $this->level_id, true);        
       
        if (isset($_GET['News']['course_id'])) {            
            
            $criteria->compare('course_name',$_GET['News']['course_id'], true);
        }

        if ($this->news_type == 'Level News') {
            $this->news_type = 'LEVEL_NEWS';
        } else if ($this->news_type == 'Broadcast News') {
            $this->news_type = 'BROADCAST_NEWS';
        } else {
            $this->news_type = "";
        }


        $criteria->compare('news_type', $this->news_type, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function filter($news_type) {

        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_type=:news_type', array(':news_type' => $news_type))
                ->queryAll();
        return $data;
    }

    public function getAttachmentNames($news_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_id=:news_id', array(':news_id' => $news_id))
                ->queryAll();

        //echo $data[0]['attachment'];die();
        return $data[0]['attachment'];
    }

    public function changeNewsTypeName($newsType) {

        if ($newsType == 'LEVEL_NEWS') {
            $newsType = 'Level News';
        } else if ($newsType == 'BROADCAST_NEWS') {
            $newsType = 'Broadcast News';
        } else {
            $newsType = '';
        }
        return $newsType;
    }

    public function getCourseOfNews($newsid) {
        $newsdata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_id=:news_id', array(':news_id' => $newsid))
                ->queryAll();

        $leveldata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $newsdata[0]['level_id']))
                ->queryAll();
        return $leveldata[0]['course_id'];
    }

    public function getLevelOfNews($newsid) {
        $subjectdata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_id=:news_id', array(':news_id' => $newsid))
                ->queryAll();

        return $subjectdata[0]['level_id'];
    }

    public function getCourseOfNewsForAdmin($lvlid) {

        if ($lvlid == NULL) {
            return 'N/A';
        } else {
            
            $leveldata = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('level')
                    // ->where('level_id=:level_id', array(':level_id' => $newsdata[0]['level_id']))
                    ->where('level_id=:level_id', array(':level_id' => $lvlid))
                    ->queryAll();


            $coursedata = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('course')
                    ->where('course_id=:course_id', array(':course_id' => $leveldata[0]['course_id']))
                    ->queryAll();
            //echo "MM".$coursedata[0]['course_name'];die();
            return $coursedata[0]['course_name'];
        }
    }
    
    
     public function getNewsAttachment($news_id) {
        if ($news_id != "") {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('news')
                    ->where('news_id=:news_id', array(':news_id' => $news_id))
                    ->queryAll();
            return $data[0]['attachment'];
        }
    }

}
