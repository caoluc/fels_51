<?php

class LessonController extends \BaseController
{
    /**
     * Display a listing word.
     *
     * @return Response
     */
    public function question($categoryId)
    {
        $userId = Auth::user()->id;
        LessonService::init($categoryId, $userId);
        $checkComplete = false;
        if (WordService::getLearnedNum($categoryId) == WordService::getTotalWord($categoryId)) {
            $checkComplete = true;

            return View::make('lessons.question', [
                'checkComplete' => $checkComplete,
            ]);
        }
        $currentLesson = LessonService::getCurrentLesson($categoryId, $userId);
        $question = AnswerSheetService::getQuestionLesson($currentLesson->id);

        if (AnswerSheetService::check($currentLesson->id, $userId)) {
            for ($i = 0; $i<LessonService::getMaxWordLesson($categoryId); $i++) {
                AnswerSheetService::initQuestion($currentLesson->id, $question[$i], $userId, $categoryId);
            }
        }
        $leanNum = AnswerSheetService::answerCount($currentLesson->id);

        return View::make('lessons.question', [
            'categoryId'     => $categoryId,
            'checkComplete'  => $checkComplete,
            'currentLesson'  => $currentLesson,
            'question'       => $question,
            'learnNum'       => $leanNum,
            'answerSheet'    => AnswerSheetService::get($currentLesson->id, $question[$leanNum], $userId),
        ]);
    }

    /**
     * Submit a question.
     *
     * @return Response
     */
    public function submit($answerSheetId, $oldAnswerId)
    {
        $answer = [];
        $answerSheet = AnswerSheet::find($answerSheetId);
        $word = Word::find($answerSheet->word_id);
        if ($answerSheet->word_id == $oldAnswerId) {
            $answer['status'] = Config::get('lesson.user_answer_true');
        } else {
            $answer['status'] = Config::get('lesson.user_answer_false');
        }
        $answer['user_answer_id'] = $oldAnswerId;
        AnswerSheetService::update($answerSheetId, $answer);
        $answerNum = AnswerSheetService::countAnswer($answerSheet->lesson_id, $answerSheet->user_id);
        if ($answerNum == Config::get('lesson.word_num')) {
            return Redirect::action('LessonController@result', [$answerSheet->lesson_id]);
        } else {
            return Redirect::action('LessonController@question', [$word->category_id]);
        }
    }

    /**
     * Show result 1 question.
     *
     * @return Response
     */
    public function result($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        $categoryId = $lesson->category_id;
        $category = Category::find($categoryId);
        LessonService::result($lessonId);

        return View::make('lessons.result', [
            'answerSheets'  => AnswerSheetService::getData($lessonId, Auth::user()->id),
            'category'      => $category,
            'lessonId'      => $lessonId,
        ]);
    }
}
