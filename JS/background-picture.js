const displayBGs = document.querySelector('.show')
const images_container = document.querySelector('.pics-container')
const images = images_container.querySelectorAll('img')
const bgImage = localStorage.getItem('background')
const title = document.querySelector('.changer')

if (bgImage) {
    document.body.style.backgroundImage = `url(../../images/background/${bgImage})`
    bgImage.includes('8') ? title.style.color = "#f6f6f6" : title.style.color = "#333333"
}

displayBGs.addEventListener("click", () => {
    console.log(images_container.style.display)

    if (images_container.style.display === 'none' || !images_container.style.display) return images_container.style.display = 'grid'
    images_container.style.display = 'none'
})

images.forEach(img => {
    img.addEventListener('click', (e) => {
        localStorage.setItem('background', `background-${e.target.id}.jpg`)
        e.target.id === '8' ? title.style.color = "#f6f6f6" : title.style.color = "#333333"

        if (bgImage) document.body.style.backgroundImage = `url(../../images/background/background-${e.target.id}.jpg)`
    })
})