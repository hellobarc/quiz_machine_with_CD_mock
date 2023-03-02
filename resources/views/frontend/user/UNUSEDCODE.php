$fillblanks = isset($data['fillblanks'])?$data['fillblanks']:null;
            $fillblankQuestionId = isset($data['fillBlank_question_id'])?$data['fillBlank_question_id']:null;
            $fillBlank_quiz_type = isset($data['fillBlank_quiz_type'])?$data['fillBlank_quiz_type']:null;
            $fillblankArr = isset($data['user_fillBlank_ans'])?$data['fillBlank_quiz_type']:null;
            $fillblankJson = json_encode(isset($data['user_fillBlank_ans'])?$data['user_fillBlank_ans']:null);