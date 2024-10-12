const time = document.querySelector('.time')
const time2 = document.querySelector('.time2')
const play = document.querySelector('.play')
const stop = document.querySelector('.stop')
const id = document.querySelector('.id').innerText

function init_counter(id) {
    const key = `vehicle_${id}`

    if (!localStorage.getItem(key)) {
        const startTime = new Date().getTime()
        localStorage.setItem(key, startTime)
    }

    update_time(id)
}

function stop_counter(id) {
    const key = `vehicle_${id}`
    const startTime = localStorage.getItem(key)

    if (startTime) {
        const endTime = new Date().getTime()
        const elapsedTime = (endTime - startTime) / 1000 / 3600

        localStorage.removeItem(key)
        time2.value = Math.floor(elapsedTime)
        console.log(elapsedTime)
    }
}

function update_time(id) {
    const key = `vehicle_${id}`
    const startTime = localStorage.getItem(key)

    if (startTime) {
        setInterval(() => {
            const currentTime = new Date().getTime()
            const elapsedTime = (currentTime - startTime) / 1000

            time.value = formatTime(Math.floor(elapsedTime))
        }, 1000);
    }
}

function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600)
    const minutes = Math.floor((seconds % 3600) / 60)
    const remainingSeconds = seconds % 60

    const formatHours = String(hours).padStart(2, '0')
    const formatMinutes = String(minutes).padStart(2, '0')
    const formatSeconds = String(remainingSeconds).padStart(2, '0')

    return `${formatHours}:${formatMinutes}:${formatSeconds}`
}

play.addEventListener('click', (e) => {
    e.preventDefault()
    init_counter(id)
})

stop.addEventListener('click', (e) => {
    clearInterval()
    stop_counter(id)
})

window.addEventListener('load', () => update_time(id))