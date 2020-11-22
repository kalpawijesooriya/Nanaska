<?php

/**
 * This is the model class for table "question".
 *
 * The followings are the available columns in table 'question':
 * @property integer $question_id
 * @property integer $subject_area_id
 * @property string $question_type
 * @property integer $number_of_marks
 * @property string $question_text
 * @property integer $exclude_from_dynamic
 * @property integer $status
 * @property integer $author_id
 * @property integer $approved
 * @property integer date_created  
 * @property string exhibit_attachment
 * @property string $question_logic
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 * @property PaperQuestion[] $paperQuestions
 * @property SubjectArea $subjectArea
 * @property QuestionPart[] $questionParts
 */
class Question extends CActiveRecord {

    public $course_id;
    public $level_id;
    public $subject_id;
    public $hotspot_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Question the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject_area_id, question_type, number_of_marks, question_text', 'required'),
            array('subject_area_id, number_of_marks, exclude_from_dynamic, status', 'numerical', 'integerOnly' => true),
            array('question_type', 'length', 'max' => 22),
            array('exhibit_attachment', 'file', 'types' => 'jpg, gif, png,jpeg,PNG,JPG,JPEG,GIF,TIF,tif', 'allowEmpty' => true),
            array('question_logic', 'length', 'max' => 65536),
            // array('exhibit_attachment', 'default', 'setOnEmpty' => true, 'value' => null),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_id, subject_area_id, question_type, number_of_marks, question_text, exclude_from_dynamic, status, author_id, approved, date_created, question_logic', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answers' => array(self::HAS_MANY, 'Answer', 'question_id'),
            'answerTexts' => array(self::HAS_MANY, 'AnswerText', 'question_id'),
            'examQuestions' => array(self::HAS_MANY, 'ExamQuestion', 'question_id'),
            'headings' => array(self::HAS_MANY, 'Heading', 'question_id'),
            'paperQuestions' => array(self::HAS_MANY, 'PaperQuestion', 'question_id'),
            'subjectArea' => array(self::BELONGS_TO, 'SubjectArea', 'subject_area_id'),
            'questionParts' => array(self::HAS_MANY, 'QuestionPart', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'question_id' => 'Question ID',
            'subject_area_id' => 'Subject Area',
            'question_type' => 'Question Type',
            'number_of_marks' => 'Number Of Marks',
            'question_text' => 'Question Text',
            'exclude_from_dynamic' => 'Exclude From Dynamic',
            'status' => 'Status',
            'exhibit_attachment' => 'Upload Exhibit',
            'question_logic' => 'Question Logic',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $user_id = Yii::app()->user->getId();
        //$super_admin    = (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") ? $user_id : 0;

        $criteria = new CDbCriteria;

        $criteria->with = array('subjectArea', 'subjectArea.subject', 'subjectArea.subject.level', 'subjectArea.subject.level.course');

        if (isset($_GET['Question']['subject_id'])) {
            if ($_GET['Question']['subject_id'] != "") {
                $subject_name = Subject::model()->getSubjectName($_GET['Question']['subject_id']);
                $criteria->compare('subject.subject_name', $subject_name, true);
            }
        }


        if (isset($_GET['Question']['level_id'])) {
            if ($_GET['Question']['level_id'] != "") {
                $level_name = Level::model()->getLevelName($_GET['Question']['level_id']);
                $criteria->compare('level_name', $level_name, true);
            }
        }

        if (isset($_GET['Question']['course_id'])) {
            if ($_GET['Question']['course_id'] != "") {
                $course_name = Course::model()->getCourseName($_GET['Question']['course_id']);
                $criteria->compare('course_name', $course_name, true);
            }
        }

        if (isset($_GET['Question']['subject_area_id'])) {
            if ($_GET['Question']['subject_area_id'] != "") {
                $subjectarea_name = SubjectArea::model()->getSubjectAreaName($this->subject_area_id);
                $criteria->compare('subject_area_name', $subjectarea_name, true);
            }
        }

        if (isset($_GET['Question']['question_type'])) {
            if ($_GET['Question']['question_type'] != "" || $_GET['Question']['question_type'] != "empty") {
                $criteria->compare('question_type', $this->question_type, true);
            }
        }



        $criteria->compare('question_id', $this->question_id);
        //  $criteria->compare('subjectArea.subject_area_name', $this->subject_area_id);

        $criteria->compare('number_of_marks', $this->number_of_marks);
        $criteria->compare('question_text', $this->question_text, true);
        $criteria->compare('exclude_from_dynamic', $this->exclude_from_dynamic);
        $criteria->compare('question_logic', $this->question_logic, true);


        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
            //$criteria->compare('author_id', 928);
        } else {
            $criteria->compare('author_id', $user_id);
        }

        if ($this->status == "Active") {
            $criteria->compare('status', 1);
        } else if ($this->status == "In-Active") {
            $criteria->compare('status', 0);
        }



        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function bbcode_to_html($text) {

        $bbcode = array("<", ">",
            "[ul]", "[li]", "[/li]", "[/ul]",
            "[img]", "[/img]",
            "[b]", "[/b]",
            "[u]", "[/u]",
            "[i]", "[/i]",
            '[color="', "[/color]",
            "[size=\"", "[/size]",
            '[url="', "[/url]",
            "[mail=\"", "[/mail]",
            "[code]", "[/code]",
            "[quote]", "[/quote]",
            '"]');
        $htmlcode = array("&lt;", "&gt;",
            "<ul>", "<li>", "</li>", "</ul>",
            "<img src=\"", "\">",
            "<b>", "</b>",
            "<u>", "</u>",
            "<i>", "</i>",
            "<span style=\"color:", "</span>",
            "<span style=\"font-size:", "</span>",
            '<a href="', "</a>",
            "<a href=\"mailto:", "</a>",
            "<code>", "</code>",
            "<table width=100% bgcolor=lightgray><tr><td bgcolor=white>", "</td></tr></table>",
            '">');
        $newtext = str_replace($bbcode, $htmlcode, $text);
        $newtext = nl2br($newtext); //second pass
        return $newtext;

        /* $bbtags = array(
          '[heading1]' => '<h1>','[/heading1]' => '</h1>',
          '[heading2]' => '<h2>','[/heading2]' => '</h2>',
          '[heading3]' => '<h3>','[/heading3]' => '</h3>',
          '[h1]' => '<h1>','[/h1]' => '</h1>',
          '[h2]' => '<h2>','[/h2]' => '</h2>',
          '[h3]' => '<h3>','[/h3]' => '</h3>',

          '[paragraph]' => '<p>','[/paragraph]' => '</p>',
          '[para]' => '<p>','[/para]' => '</p>',
          '[p]' => '<p>','[/p]' => '</p>',
          '[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
          '[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
          '[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
          '[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',

          '[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
          '[italic]' => '<span style="font-weight:bold;">','[/italic]' => '</span>',
          '[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
          '[color]' => '<span style="color:#cc3366;">','[/color]' => '</span>',
          '[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
          '[i]' => '<span style="font-weight:bold;">','[/i]' => '</span>',
          '[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
          '[break]' => '<br>',
          '[br]' => '<br>',
          '[newline]' => '<br>',
          '[nl]' => '<br>',

          '[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
          '[list]' => '<ul>','[/list]' => '</ul>',
          '[ul]' => '<ul>','[/ul]' => '</ul>',

          '[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
          '[ol]' => '<ol>','[/ol]' => '</ol>',
          '[list_item]' => '<li>','[/list_item]' => '</li>',
          '[li]' => '<li>','[/li]' => '</li>',

          '[*]' => '<li>','[/*]' => '</li>',
          '[code]' => '<code>','[/code]' => '</code>',
          '[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
          '[pre]' => '<pre>','[/pre]' => '</pre>',
          '[color=([a-zA-Z]*|\#?[0-9a-fA-F]{6})](.*?)\[/color\]'=>'<span style="color: $1">$2</span>',
          );

          $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

          $bbextended = array(
          "/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\">$1</a>",
          "/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\">$2</a>",
          "/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
          "/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
          "/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" />",
          "/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
          "/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
          "/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",

          );

          foreach($bbextended as $match=>$replacement){
          $bbtext = preg_replace($match, $replacement, $bbtext);
          }
          return $bbtext; */
    }

    // Convert BBCodes to their HTML equivalent
    /* FUNCTION do_bbcode($text){
      GLOBAL $lang_common, $FORUM_user;

      IF (STRPOS($text, 'quote') !== FALSE){
      $text = STR_REPLACE('[quote]', '</p><blockquote><div class="incqbox"><p>', $text);
      $text = PREG_REPLACE('#\[quote=("|"|\'|)(.*)\\1\]#seU', '"</p><blockquote><div class=\"incqbox\"><h4>".str_replace(array(\'[\', \'\\"\'), array(\'[\', \'"\'), \'$2\')." ".$lang_common[\'wrote\'].":</h4><p>"', $text);
      $text = PREG_REPLACE('#\[\/quote\]\s*#', '</p></div></blockquote><p>', $text);
      }

      $pattern = ARRAY('#\[b\](.*?)\[/b\]#s',
      '#\[i\](.*?)\[/i\]#s',
      '#\[u\](.*?)\[/u\]#s',
      '#\[url\]([^\[]*?)\[/url\]#e',
      '#\[url=([^\[]*?)\](.*?)\[/url\]#e',
      '#\[email\]([^\[]*?)\[/email\]#',
      '#\[email=([^\[]*?)\](.*?)\[/email\]#',
      '#\[color=([a-zA-Z]*|\#?[0-9a-fA-F]{6})](.*?)\[/color\]#s');

      $replace = ARRAY('<strong>$1</strong>',
      '<em>$1</em>',
      '<span class="bbu">$1</span>',
      'handle_url_tag(\'$1\')',
      'handle_url_tag(\'$1\', \'$2\')',
      '<a href="mailto:$1">$1</a>',
      '<a href="mailto:$1">$2</a>',
      '<span style="color: $1">$2</span>');

      $text = PREG_REPLACE($pattern, $replace, $text);

      RETURN $text;



      /////////////////////////////////////

      // If the message contains a code tag we have to split it
      // up (text within [code][/code] shouldn't be touched)
      IF (STRPOS($text, '[code]') !== FALSE && STRPOS($text, '[/code]') !== FALSE){
      LIST($inside, $outside) = split_text($text, '[code]', '[/code]');
      $outside = ARRAY_MAP('ltrim', $outside);
      $text = IMPLODE('<">', $outside);
      }
      } */

    public function getQuestionsBySubjectID($subject_id) {
        $questionIDs = Array();

        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_area')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();



        foreach ($data as $item) {
            $data2 = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('question')
                    ->where('subject_area_id=:subject_area_id', array(':subject_area_id' => $item['subject_area_id']))
                    ->queryAll();
            foreach ($data2 as $item2) {
                $questionIDs[] = $item2['question_id'];
            }
        }

        return $questionIDs;
    }

    public function getQuestionsBySubjectAreaAndQuestionType($subject_area_id, $question_type) {
        $questionIDs = array();
        $questionIDs = Question::model()->findColumn('question_id', 'subject_area_id=:subject_area_id AND question_type=:question_type', array(':subject_area_id' => $subject_area_id, ':question_type' => $question_type));

        return $questionIDs;
    }

    public function getSubjectAreaOfQuestion($question_id) {
        $questiondata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        $subject_area_id = $questiondata[0]['subject_area_id'];

        $subjectareadata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_area')
                ->where('subject_area_id=:subject_area_id', array(':subject_area_id' => $subject_area_id))
                ->queryAll();

        return $subjectareadata[0]['subject_area_name'];
    }

    public function getQuestion($question_id) {
        $questiondata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $questiondata[0];
    }

    public function getQuestionTypeLabel($question_type) {

        if ($question_type == "SINGLE_ANSWER") {
            return "Single Answer";
        } else if ($question_type == "MULTIPLE_ANSWER") {
            return "Multiple Answer";
        } else if ($question_type == "SHORT_WRITTEN") {
            return "Short Written Answer";
        } else if ($question_type == "DRAG_DROP_TYPEA_ANSWER") {
            return "Drag & Drop Type A Answer";
        } else if ($question_type == "DRAG_DROP_TYPEB_ANSWER") {
            return "Drag & Drop Type B Answer";
        } else if ($question_type == "DRAG_DROP_TYPEC_ANSWER") {
            return "Drag & Drop Type C Answer";
        } else if ($question_type == "DRAG_DROP_TYPED_ANSWER") {
            return "Drag & Drop Type D Answer";
        } else if ($question_type == "DRAG_DROP_TYPEE_ANSWER") {
            return "Drag & Drop Type E Answer";
        } else if ($question_type == "MULTIPLE_CHOICE_ANSWER") {
            return "Multiple Choice Answer";
        } else if ($question_type == "TRUE_OR_FALSE_ANSWER") {
            return "True Or False Answer";
        } else if ($question_type == "HOT_SPOT_ANSWER") {
            return "Hot-Spot Answer";
        } else if ($question_type == "ESSAY_ANSWER") {
            return "Essay Answer";
        }
    }

    public function getExcludeDynamicLabel($exclude_from_dynamic) {
        if ($exclude_from_dynamic == 1) {
            return 'Yes';
        } else if ($exclude_from_dynamic == 0) {
            return 'No';
        }
    }

    public static function displayStyleAnswer($i) {
        if ($i != 1) {
            return 'display: none';
        } else {
            return 'display: block';
        }
    }

    public static function displayStyleAnswer2($i, $size) {
        if ($i > $size + 1) {
            return 'display: none';
        } else {
            return 'display: block';
        }
    }

    public function getStatusLabel($status) {
        if ($status == 1) {
            return "Active";
        } else if ($status == 0) {
            return "In-Active";
        }
    }

    public static function TruncateText($text, $max_len) {
        $len = mb_strlen($text, 'UTF-8');
        if ($len <= $max_len)
            return $text;
        else
            return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
    }

    public function getUnApprovedQuestionsByUserId($user_id) {
        $questions = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('author_id=:author_id', array(':author_id' => $user_id))
                ->queryAll();
        return $questions;
    }

    public function getSubjectAreaIdOfQuestion($question_id) {
        $questiondata = Yii::app()->db->createCommand()
                ->select('subject_area_id')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryScalar();
        return $questiondata;
    }

    public function getQuestionText($question_id) {
        $questiontext = Yii::app()->db->createCommand()
                ->select('question_text')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();

        return $questiontext[0]['question_text'];
    }

    public function behaviors() {
        return array('CAdvancedArFindBehavior' => array(
                'class' => 'application.extensions.CAdvancedArFindBehavior'));
    }

    public function getDissaprovedQuestions($user_id) {

        $questiondata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
//                ->where('author_id=:author_id')
                ->where('author_id=' . $user_id . ' AND approved=0')
                ->queryAll();
        return $questiondata;
    }

    public function getQuestionTypeByQuestionId($questionid) {
        $questionype = Yii::app()->db->createCommand()
                ->select('question_type')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $questionid))
                ->queryAll();

        return $questionype[0]['question_type'];
    }

    public function getQuestionExhibit($question_id) {
        if ($question_id != "") {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('question')
                    ->where('question_id=:question_id', array(':question_id' => $question_id))
                    ->queryAll();
            return $data[0]['exhibit_attachment'];
        }
    }

    public function getRandomQuestions($subject_area_id, $question_type, $no_of_questions) {
        $data = Yii::app()->db->createCommand()
                ->select('question_id')
                ->from('question')
                ->where('subject_area_id=:subject_area_id AND question_type=:question_type', array(':subject_area_id' => $subject_area_id, ':question_type' => $question_type))
                ->order(array('RAND()'))
                ->limit($no_of_questions)
                ->queryAll();
//        print_r(sizeof($data)); die;
//        $selected_question_ids = array();
//
//        if ($data != null) {
//            for ($count = 1; $count <= $no_of_questions; $count++) {
//                $index = rand(0, sizeof($data) - 1);
//
//                $question_id = $data[$index];
//
//
//                if (!in_array($question_id, $selected_question_ids)) {
//                    $selected_question_ids[] = $question_id;
//                }
//            }
//        }


        return $data;
    }

    public function getQuestionObj($id) {
        return $this->findByPk($id);
    }

    public function getQuestionsForSubjectArea($subjectAreaID) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('subject_area_id=' . $subjectAreaID);
        $criteria->order = "question_id ASC";
        return $this->model()->findAll($criteria);
    }
    public function getHotspotQuestionsId($question_id) {
        $data = array();
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('hotspot')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        if(count($data) > 0){
            return $data;
        }else{
            return null;
        }
        
    }
    
    public function checkQuestionStatus($question_id){
        $data = Yii::app()->db->createCommand()
                ->select('status')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryScalar();

        return $data;
    }
    
    
}
