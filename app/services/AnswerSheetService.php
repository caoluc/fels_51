<?php

class AnswerSheetService extends BaseService
{
    public static function answerCount($lessonId)
    {
        $count = 0;
        $count = DB::table(AnswerSheet::getTableName())->where('lesson_id', '=', $lessonId)->where('status', '<>', 0)->count();

        return $count;
    }
    public static function getQuestionLesson($lessonId)
    {
        $lesson = DB::table(Lesson::getTableName())->where('id', '=', $lessonId)->first();
        $questions = unserialize($lesson->question_srlz);

        return $questions;
    }
    public static function makeAnswer($wordId, $categoryId)
    {
        $answer = [];
        $correct = Answer::where('word_id', '=', $wordId)->first();
        array_push($answer, $correct->id);
        $inCorrects = Word::where('id', '<>', $wordId)
            ->where('category_id', '=', $categoryId)
            ->take(Config::get('lesson.word_num'))
            ->orderByRaw("RAND()")
            ->get();
        foreach ($inCorrects as $inCorrect) {
            array_push($answer, $inCorrect->id);
        }
        shuffle($answer);

        return $answer;
    }
    public static function initQuestion($lessonId, $wordId, $userId, $categoryId)
    {
        $userQuestion = [];
        $userQuestion['user_id'] = $userId;
        $userQuestion['lesson_id'] = $lessonId;
        $userQuestion['word_id'] = $wordId;
        $answer = AnswerSheetService::makeAnswer($wordId, $categoryId);
        for ($i = 0; $i<4; $i++) {
            $userQuestion['answer_'.$i] = $answer[$i];
        }
        DB::table(AnswerSheet::getTableName())->insert($userQuestion);
    }
    public static function get($lessonId, $wordId, $userId)
    {
        $userQuestion = AnswerSheet::where('lesson_id', '=', $lessonId)
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->where('status', '=', 0)
            ->first();

        return $userQuestion;
    }
    public static function countAnswer($lessonId, $userId)
    {
        $count = 0;
        $count = AnswerSheet::where('lesson_id', '=', $lessonId)
            ->where('user_id', '=', $userId)
            ->where('status', '<>', 0)
            ->count();

        return $count;
    }
    public static function answerCorrect($lessonId, $userId)
    {
        $count = 0;
        $count = AnswerSheet::where('lesson_id', '=', $lessonId)
            ->where('user_id', '=', $userId)
            ->where('status', '=', Config::get('lesson.user_answer_true'))
            ->count();

        return $count;
    }
    public static function getData($lessonId, $userId)
    {
        $answerSheets = AnswerSheet::where('lesson_id', '=', $lessonId)
            ->where('user_id', '=', $userId)
            ->get();

        return $answerSheets;
    }
    public static function show($answerId)
    {
        $answer = Answer::find($answerId);

        return $answer->content;
    }
    public static function getSetQuestion($lessonId, $userId)
    {
        $setQuestions = AnswerSheet::where('lesson_id', '=', $lessonId)
            ->where('user_id', '=', $userId)
            ->first();
        if (!$setQuestions) {
            return;
        }

        return $setQuestions;
    }
    public static function check($lessonId, $userId)
    {
        $setQuestion = AnswerSheetService::getSetQuestion($lessonId, $userId);
        if (!$setQuestion) {
            return true;
        }

        return false;
    }
    public static function update($id, $data)
    {
        $answerSheet = AnswerSheet::find($id);
        foreach ($data as $key => $value) {
            $answerSheet->$key = $value;
        }
        $answerSheet->save();

        return $answerSheet;
    }
    public static function checkResult($answerSheet)
    {
        if ($answerSheet->status == Config::get('lesson.user_answer_true')) {
            return true;
        }

        return false;
    }
}
