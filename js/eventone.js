const __EVENTONE__ = {};
//__EVENTONE__ = {
//  action1: [ // actions
//    [-1, (...args) => {}], // reactors
//    [0, (...args) => {}],
//    ...
//  ],
//  ...
//};

function action(label, inPlaceCallback) {
  if (inPlaceCallback)
    when(label, inPlaceCallback);

  return function (...args) {
    if (__EVENTONE__[label]) // giving shorten name
      __EVENTONE__[label].forEach(([, reactor]) => reactor(...args));
    else console.warn(`EVENTONE: Calling action of not defined label (${label})`);
  };
}

function when(actionLabel, reactor, callPlace = 0) {
  if (typeof actionLabel == 'string') {
    whenLogic(actionLabel);
  } else if (Array.isArray(actionLabel)) {
    for (let singleActionLabel of actionLabel)
      whenLogic(singleActionLabel);
  } else {
    console.warn('EVENTONE: Unrecognized type of when type, try string or array of strings');
  }

  function whenLogic(actionLabel) {
    if (!__EVENTONE__[actionLabel]) // check actionLabel exist
      __EVENTONE__[actionLabel] = []; // create if not

    __EVENTONE__[actionLabel].push([callPlace, reactor]); // pushing reactor inside
    __EVENTONE__[actionLabel].sort((a, b) => a[0] - b[0]); // sorting reactors by callPlace
  }
}
