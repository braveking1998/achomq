export const useQuestionStatus = (question) => {
  if (question.deleted_at !== null) {
    return {
      value: "لغو شده",
      num_value: -1,
    };
  }

  if (question.status === 1) {
    return {
      value: "معلق",
      num_value: 1,
    };
  }

  if (question.status === 2) {
    return {
      value: "تایید شده",
      num_value: 2,
    };
  }
};
