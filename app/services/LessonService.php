<?php

class LessonService extends BaseService
{
    public static function generateLesson($categoryId)
    {
        $userId = Auth::user()->id;
        $questions = DB::table(Word::getTableName())
            ->whereNotIn('id', function ($query) {
                $query->select('word_id')
                      ->from('answer_sheets')
                      ->where('answer_sheets.user_id', '=', Auth::user()->id);
            })
            ->where('category_id', '=', $categoryId)
            ->take(Config::get('lesson.word_num'))
            ->orderByRaw("RAND()")
            ->get();
        if (empty($questions)) {
            return;
        }
        $word = [];
        foreach ($questions as $question) {
            array_push($word, $question->id);
        }
        $lesson = [];
        $lesson['user_id'] = $userId;
        $lesson['category_id'] = $categoryId;
        $lesson['question_srlz'] = serialize($word);
        DB::table(Lesson::getTableName())->insert($lesson);
    }
    public static function getCurrentLesson($categoryId, $userId)
    {
        $lesson = Lesson::where('user_id', '=', $userId)->where('category_id', '=', $categoryId)->where('status', '=', 0)->first();
        if (!empty($lesson)) {
            return $lesson;
        }

        return;
    }
    public static function count($categoryId)
    {
        $count = 0;
        $userId = Auth::user()->id;
        $count = Lesson::where('user_id', '=', $userId)->where('category_id', '=', $categoryId)->count();

        return $count;
    }
    public static function sum($categoryId)
    {
        $sum = LessonService::count($categoryId) * Config::get('lesson.word_num');

        return $sum;
    }
    public static function check($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if ($lesson->status == 0) {
            return false;
        }

        return true;
    }
    public static function update($id, $data)
    {
        $lesson = Lesson::find($id);
        foreach ($data as $key => $value) {
            $lesson->$key = $value;
        }
        $lesson->save();

        return $lesson;
    }
    public static function init($categoryId, $userId)
    {
        $lessonCount = Lesson::where('user_id', '=', $userId)
            ->where('category_id', '=', $categoryId)
            ->count();
        if ($lessonCount == 0) {
            LessonService::generateLesson($categoryId);
        }
    }
    public static function getMaxWordLesson($categoryId)
    {
        $max = Config::get('lesson.word_num');
        $wordRemain = WordService::getTotalWord($categoryId) - WordService::getLearnedNum($categoryId);
        if ($max > $wordRemain) {
            return $wordRemain;
        }

        return $max;
    }
    public static function result($lessonId)
    {
        $userId = Auth::user()->id;
        $answerSheets = AnswerSheetService::getData($lessonId, $userId);
        $unit = [];
        $unit['status'] = Config::get('lesson.complete');
        $lesson = Lesson::find($lessonId);
        $categoryId = $lesson->category_id;
        $category = Category::find($categoryId);
        LessonService::update($lessonId, $unit);
        $activities = [];
        $activities['user_id'] = $userId;
        $activities['lesson_id'] = $lessonId;
        $activities['category_id'] = $categoryId;
        $activityData = DB::table(Activity::getTableName())->where('lesson_id', '=', $lessonId)->first();
        if (!$activityData) {
            DB::table(Activity::getTableName())->insert($activities);
        }
        if (WordService::getLearnedNum($categoryId) != WordService::getTotalWord($categoryId)) {
            LessonService::generateLesson($categoryId);
        }
    }
    public static function getActivities($userId)
    {
        $activities = Activity::where('user_id', '=', $userId)->get();

        return $activities;
    }
    public static function getAllActivities()
    {
        $activities = Activity::all();

        return $activities;
    }
    public static function getTimeFinish($lessonId)
    {
        $lesson = Lesson::find($lessonId);

        return $lesson->updated_at;
    }
}
