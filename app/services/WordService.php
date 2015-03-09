<?php

class WordService extends BaseService
{
    const LEARNED       = 1;
    const NOT_LEARNED   = 2;
    const ALL           = 3;

    public static function getList($categoryId, $filter)
    {
        $learned = DB::table('words')
            ->whereIn('id', function ($query) {
                $query->select('word_id')
                      ->from('answer_sheets')
                      ->where('answer_sheets.user_id', '=', Auth::user()->id)
                      ->where('answer_sheets.status', '<>', 0);
            })
            ->where('category_id', '=', $categoryId)
            ->get();
        $notLearned = DB::table('words')
            ->whereNotIn('id', function ($query) {
                $query->select('word_id')
                      ->from('answer_sheets')
                      ->where('answer_sheets.user_id', '=', Auth::user()->id)
                      ->where('answer_sheets.status', '<>', 0);
            })
            ->where('category_id', '=', $categoryId)
            ->get();
        $all = DB::table('words')->where('category_id', '=', $categoryId)->get();
        switch ($filter) {
            case self::LEARNED:
                return $learned;
                break;
            case self::NOT_LEARNED:
                return $notLearned;
                break;
            case self::ALL:
                return $all;
                break;
            default:
                break;
        }
    }

    public static function getLearnedNum($categoryId)
    {
        $num = DB::table('words')
            ->whereIn('id', function ($query) {
                $query->select('word_id')
                      ->from('answer_sheets')
                      ->where('answer_sheets.user_id', '=', Auth::user()->id)
                      ->where('status', '<>', 0);
            })
            ->where('category_id', '=', $categoryId)
            ->count();

        return $num;
    }

    public static function getTotalWord($categoryId)
    {
        $total = DB::table('words')->where('category_id', '=', $categoryId)->count();

        return $total;
    }

    public static function getAnswer($wordId)
    {
        $answer = Answer::where('id', '=', $wordId)->first();

        return $answer->content;
    }

    public static function show($wordId)
    {
        $view = '';
        $word = Word::find($wordId);
        $view .= $word->content;

        return $view;
    }
    public static function getTotalLearned($userId)
    {
        $total = AnswerSheet::where('user_id', '=', $userId)
            ->where('status', '<>', 0)
            ->count();

        return $total;
    }
}
