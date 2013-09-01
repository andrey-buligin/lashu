function wbg_fixflash(containerID){
	var flashContainer = document.getElementById(containerID);
	var flashMovie = document.createElement("div");
	flashMovie.innerHTML = flashContainer.innerHTML;
	flashContainer.parentNode.insertBefore(flashMovie, flashContainer);
	flashContainer.parentNode.removeChild(flashContainer);
	flashMovie.setAttribute("id",containerID);
}