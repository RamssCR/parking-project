const bgImage = localStorage.getItem('background')
if (bgImage) {
    document.body.style.backgroundImage = `url(../../images/background/${bgImage})`
    document.querySelectorAll('.changer').forEach(title => bgImage.includes("8") ? title.style.color = "#f6f6f6" : title.style.color = "#222222")
}