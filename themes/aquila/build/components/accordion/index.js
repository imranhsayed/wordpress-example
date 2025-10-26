(function() {
'use strict';
document.addEventListener("DOMContentLoaded",()=>{document.querySelectorAll(".accordion").forEach(a=>{const t=a.querySelectorAll(".accordion__trigger");t.forEach(e=>{e.addEventListener("click",()=>{const c=e.getAttribute("aria-expanded")==="true",r=e.getAttribute("aria-controls"),n=document.getElementById(r);t.forEach(o=>{const i=o.getAttribute("aria-controls"),d=document.getElementById(i);o.setAttribute("aria-expanded","false"),d&&d.setAttribute("hidden","")}),!c&&n&&(e.setAttribute("aria-expanded","true"),n.removeAttribute("hidden"))})})})});

})();