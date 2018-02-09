/* DOES NOT WORK! DO NOT USE!
 * a scipt for having elements follow the mouse
 */

 /* Moves a single element to the current mouse position
  * takes that element
  */
function follow_mouse(element, event){
    var event = event || window.event;
    element.style.left = event.pageX;
    element.style.top = event.pageY;
}

/* Has all elements of a class follow the mouse
 * takes the name of the class of elements that will do the following
 */
function class_follow_mouse(c, event){
    var es = document.getElementsByClassName(c);
    for(var k in es){
        follow_mouse(es[k], event);
    }
}