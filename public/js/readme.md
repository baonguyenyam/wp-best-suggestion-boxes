liftChatReady is a single plain javascript function that provides a method of 
scheduling one or more javascript functions to run at some later
point when the DOM has finished loading.

It works similarly to jQuery's $(document).ready(), but this is a small
single standalone function that does not require jQuery in any way.

These are various forms of usage:

// pass a function reference
liftChatReady(fn);

// use an anonymous function
liftChatReady(function() {
    // code here
});

// pass a function reference and a context
// the context will be passed to the function as the first argument
liftChatReady(fn, context);

// use an anonymous function with a context
liftChatReady(function(ctx) {
    // code here that can use the context argument that was passed to liftChatReady
}, context);

liftChatReady(fn) can be called as many times as desired and each callback function will be
called in order when the DOM is done being parsed and is ready for manipulation.

If you call liftChatReady(fn) after the DOM is already ready, the callback with be executed
as soon as the current thread of execution finishes by using setTimeout(fn, 1).