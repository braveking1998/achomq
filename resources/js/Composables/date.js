// Imports

// @date Object
// {
// month: Number [0, 11]
// day: Number [0, 6]
// }
const useShamsiNames = () => {
  const shamsiMonthNames = [
    "فروردین",
    "اردیبهشت",
    "خرداد",
    "تیر",
    "مرداد",
    "شهریور",
    "مهر",
    "آبان",
    "آذر",
    "دی",
    "بهمن",
    "اسفند",
  ];

  const shamsiDayNames = [
    "یکشنبه",
    "دوشنبه",
    "سه شنبه",
    "چهارشنبه",
    "پنج شنبه",
    "جمعه",
    "شنبه",
  ];

  return { shamsiMonthNames, shamsiDayNames };
};

const useDaysOfMonth = () => {
  const miladiMonthDays = [
    31,
    { leap: 29, notLeap: 28 },
    31,
    30,
    31,
    30,
    31,
    31,
    30,
    31,
    30,
    31,
  ];

  const shamsiMonthDays = [
    31,
    31,
    31,
    31,
    31,
    31,
    30,
    30,
    30,
    30,
    30,
    { leap: 30, notLeap: 29 },
  ];

  return { shamsiMonthDays, miladiMonthDays };
};

// Calculate shamsi year
const useShamsiYear = (year, month, day, isLeap, daysOfMonth) => {
  let newMonth = month;

  let newDay = day; // Day 1 - month 3

  if (isLeap) {
    if (newMonth == 1) {
      if (newDay != daysOfMonth[1].leap) {
        newDay++;
      } else {
        newMonth++;
        newDay = 1;
      }
    } else if (newMonth == 11) {
      if (newDay != daysOfMonth[11]) {
        newDay++;
      } else {
        newMonth = 0;
        newDay = 1;
      }
    } else {
      if (newDay != daysOfMonth[newMonth]) {
        newDay++;
      } else {
        newMonth++;
        newDay = 1;
      }
    }
  }

  // Condition for 622 or 621
  if ((newDay >= 22 && newMonth == 2) || newMonth > 2) {
    return year - 621;
  } else {
    return year - 622;
  }
};

// Calculate shamsi month
const useShamsiMonth = (shamsiTotalDays, shamsiMonthDays) => {
  const { shamsiMonthNames } = useShamsiNames();
  let shamsiYearRemainer = shamsiTotalDays % 365;
  let monthNumber = 0;
  for (let i = 0; shamsiYearRemainer > shamsiMonthDays[i]; i++) {
    shamsiYearRemainer -= shamsiMonthDays[i];
    monthNumber++;
  }

  const shamsiMonth = shamsiMonthNames[monthNumber];

  const shamsiMonthNumber = ++monthNumber;

  return { shamsiYearRemainer, shamsiMonth, shamsiMonthNumber };
};

// total days of month
const useTotalDaysOfMonths = (month, isLeap, miladiMonthDays) => {
  let totalDaysOfMonths = 0;
  if (month) {
    for (let i = 0; i <= month - 1; i++) {
      if (i === 1) {
        if (isLeap) {
          totalDaysOfMonths += miladiMonthDays[i].leap;
        } else {
          totalDaysOfMonths += miladiMonthDays[i].notLeap;
        }
        continue;
      }
      totalDaysOfMonths += miladiMonthDays[i];
    }
  }

  return totalDaysOfMonths;
};

const useShamsiDate = (date = new Date()) => {
  // Get the full date
  const year = date.getFullYear();
  const month = date.getMonth();
  const day = date.getDate();
  const isLeap = year % 4 === 0 ? 1 : 0;

  // Get other functions
  const { shamsiMonthDays, miladiMonthDays } = useDaysOfMonth();

  // Total days of years and months
  const totalDaysOfYears = (year - 1) * 365;
  const totalDaysOfMonths = useTotalDaysOfMonths(
    month,
    isLeap,
    miladiMonthDays
  );

  // calculate shamsi year
  const shamsiYear = useShamsiYear(year, month, day, isLeap, miladiMonthDays);

  // Leap days
  const leapDaysMiladi = Math.floor((year - 1) / 4);
  const leapDaysShamsi = Math.floor((shamsiYear - 1) / 4);

  // Total days of years, months, days and leap days
  const totalDays = totalDaysOfYears + totalDaysOfMonths + day + leapDaysMiladi;

  // Shamsi total days
  const shamsiTotalDays = totalDays - 226899 - leapDaysShamsi;

  // Calculate shamsi month
  const { shamsiMonth, shamsiYearRemainer, shamsiMonthNumber } = useShamsiMonth(
    shamsiTotalDays,
    shamsiMonthDays
  );

  const shamsiDay = shamsiYearRemainer;

  return { shamsiYear, shamsiMonth, shamsiMonthNumber, shamsiDay };
};

export const useFormattedShamsiDate = (data = null) => {
  const { shamsiDayNames } = useShamsiNames();
  const { shamsiYear, shamsiMonth, shamsiDay } = useShamsiDate();
  const day = new Date(data).getDay();
  const formatedDate = `${shamsiDayNames[day]} ${shamsiDay} ${shamsiMonth} ماه ${shamsiYear}`;

  return { formatedDate };
};
