import { useLottie } from 'lottie-react'
import SuccessData from "../assets/lotties/Success.json";

const style = {
    height: 100
}


const Success = () => {
    const options = {
        animationData: SuccessData,
        loop: false,
        autoplay: true
    }

    const { View } = useLottie(options, style);

    return <>{View}</>
}

export default Success
