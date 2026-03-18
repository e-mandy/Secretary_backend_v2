import React from "react";

interface State {
    hasError: boolean
}

interface Props {
    children: React.ReactNode
}

export class GlobalErrorBoundary extends React.Component<Props, State>{
    public state: State = { hasError: false };

    public static getDerivedStateFromError(){
        return { hasError: true };
    }

    public componentDidCatch(error: Error, errorInfo: React.ErrorInfo): void {
        console.error("App Crashed : ", error, errorInfo.componentStack);
    }

    public render(): React.ReactNode {
        if(this.state.hasError){
            return (
                <div>
                    <h1>Un problème est subvenu.</h1>
                    <button onClick={() => window.location.reload()}>Recharger la page</button>
                </div>
            )
        }else{
            return this.props.children;
        }
    }
}