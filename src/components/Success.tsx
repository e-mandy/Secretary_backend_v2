import { useLottie, useLottieInteractivity } from 'lottie-react'
import SuccessData from "../assets/lotties/Success.json";

const style = {
    height: 100
}

const options = {
    animationData: SuccessData,
    autoplay: false
}

const Success = () => {
    const lottieObj = useLottie(options, style);
    const Animation = useLottieInteractivity({
        lottieObj,
        mode: "scroll",
        actions: [
            {
                visibility: [0.4, 0.9],
                type: "seek",
                frames: [0, 53]
            }
        ]
    });

    return Animation
}

export default Success
