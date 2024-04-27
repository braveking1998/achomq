export const shorten = (text, length) => {
  if (text.length > length) {
    return text.substr(0, length).concat(" ...");
  }

  return text;
};

export const dateTr = (text) => {
  const mapObj = {
    last: "قبل",
    ago: "قبل",
    next: "بعد",
    seconds: "ثانیه",
    second: "ثانیه",
    minutes: "دقیقه",
    minute: "دقیقه",
    hours: "ساعت",
    hour: "ساعت",
    days: "روز",
    day: "روز",
    months: "ماه",
    month: "ماه",
    "just now": "همین الان",
  };

  const re = new RegExp(Object.keys(mapObj).join("|"), "gi");
  const str = text.replace(re, function (matched) {
    return mapObj[matched];
  });

  return str;
};
