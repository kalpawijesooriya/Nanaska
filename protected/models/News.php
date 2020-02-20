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
            array('subject, message, send_date_time, level_id, news_type, course_id', 'required'),
            array('level_id, course_id', 'numerical', 'integerOnly' => true),
            array('subject', 'length', 'max' => 255),
            array('send_date_time', 'length', 'max' => 50),
            array('news_type', 'length', 'max' => 512),
            array('attachment', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('news_id, subject, message, send_date_time, attachment, level_id, news_type, course_id', 'safe', 'on' => 'search'),
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
            'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'news_id' => 'News',
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

        $criteria->compare('news_id', $this->news_id);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('send_date_time', $this->send_date_time, true);
        $criteria->compare('attachment', $this->attachment, true);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('news_type', $this->news_type, true);
        $criteria->compare('course_id', $this->course_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getBroadcastNews() {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_type=:news_type', array(':news_type' => 'BROADCAST_NEWS'))
                ->queryAll();

        return $data;
    }

    public function getAllTheBroadcastNews($news_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_id=:news_id', array(':news_id' => $news_id))
                ->queryAll();

        return $data;
    }

    public function getLevelNews($userid) {
        $data = array();
        $levelid = Yii::app()->db->createCommand()
                ->select('level_id')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $userid))
                ->queryRow();

        if (isset($levelid['level_id'])) {
            if ($levelid['level_id'] != null) {
                $data['msg'] = Yii::app()->db->createCommand()
                        ->select('message')
                        ->from('news')
                        ->where('level_id=' . $levelid['level_id'] . ' AND news_type = "LEVEL_NEWS"')
                        ->queryAll();

                $data['messageid'] = Yii::app()->db->createCommand()
                        ->select('news_id')
                        ->from('news')
                        ->where('level_id=' . $levelid['level_id'] . ' AND news_type = "LEVEL_NEWS"')
                        ->queryAll();
            }
        }

        return $data;
    }

    public function getLevelforNews($userid) {
        $levelid = Yii::app()->db->createCommand()
                ->select('level_id')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $userid))
                ->queryAll();
        return $levelid[0]['level_id'];
    }

    public function validateLevelID($level_id) {
        if ($level_id == NULL) {
            return false;
        } else {
            return true;
        }
    }

    public static function TruncateText($text, $max_len) {
        $len = mb_strlen($text, 'UTF-8');
        if ($len <= $max_len)
            return $text;
        else
            return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
    }

    public function getLevelNewsDetailsByNewsId($newsId) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('news_id=:news_id', array(':news_id' => $newsId))
                ->queryAll();

        if (empty($data)) {
            return null;
        } else {
            return $data;
        }
    }

}
