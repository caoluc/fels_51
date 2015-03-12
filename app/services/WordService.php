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

    public static function find($id)
    {
        return Word::find($id);
    }

    public static function get($order, $direction, $offset, $limit)
    {
        return Word::orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public static function getWordWithAnswer($order, $direction, $offset, $listLength, &$hasNext)
    {
        $query = Word::orderBy($order, $direction)->skip($offset)->take($listLength + 1);

        if (count($query) > $listLength) {
            $query = $query->slice(0, $listLength);
            $hasNext = True;
        }

        $words = $query->get();
        $words->load('category', 'answer');
        foreach($words as $word){
            $word['category_id'] = $word->category()->first()->id;
            $word['answer_content'] = isset($word->answer) ? $word->answer->content : '';
        }

        return $words;
    }

    public static function create($input)
    {
        $word = new Word;
        $word->category_id  = array_get($input, 'category_id',  $word->category_id);
        $word->content  = array_get($input, 'content',  $word->content);

        $word->save();
        $answer = [];
        $answer['word_id'] = $word->id;
        $answer['content'] = $input['answer_content'];
        DB::table(Answer::getTableName())->insert($answer);
        return $word;
    }

    public static function update($word, $input)
    {
        $word->category_id  = array_get($input, 'category_id',  $word->category_id);
        $word->content  = array_get($input, 'content',  $word->content);

        $word->save();
        $answer = [];
        $answer['word_id'] = $word->id;
        $answer['content'] = $input['answer_content'];
        DB::table(Answer::getTableName())->where('id', '=', $word->id)->update($answer);
        
        return $word;
    }

    public static function save($word)
    {
        return $word->save();
    }

    public static function delete($word)
    {
        DB::table(Answer::getTableName())->delete($word->id);
        return $word->delete();
    }

    public static function next($word)
    {
        return Word::where('id', '>', $word->id)->orderBy('id', 'asc')->first();
    }

    public static function prev($word)
    {
        return Word::where('id', '<', $word->id)->orderBy('id', 'desc')->first();
    }

    public static function validate($id, $inputs)
    {
        $validationRules = [
            'category_id'   => ['required'],
            'content'       => ['required', 'unique:words,content,NULL,id'],
        ];
        if (isset($id)) {
            $validationRules = [
                'content'       => ['required'],
            ];
        }

        $validationMessages = [
            'category_id.required'  => Lang::get('validation.words.category_id.required'),
            'content.required'         => Lang::get('validation.words.content.required'),
            'content.unique'           => Lang::get('validation.words.content.unique'),
        ];

        return Validator::make($inputs, $validationRules, $validationMessages);
    }
}
